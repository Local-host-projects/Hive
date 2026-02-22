<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatsController extends Controller
{
    public function CreatePersonaPage(){
        return view('create-persona');
    }
    private function generateSemanticWeights(string $description): array
    {
        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [[
                    'parts' => [[
                        'text' => "You are a semantic search engine for a health platform.
A user described their health situation: \"{$description}\"
Expand this into exactly 15 search terms that would find relevant patient stories.
Assign each a semantic_weight from 1-10 based on medical significance.
Include symptoms, medical terms, emotions, and lay language.
Return ONLY a JSON array. No explanation. No markdown.
Format: [{\"term\": \"example\", \"semantic_weight\": 8}]"
                    ]]
                ]],
                'generationConfig' => ['temperature' => 0.3, 'maxOutputTokens' => 400]
            ]
        );

        $text  = $response->json('candidates.0.content.parts.0.text');
        $clean = preg_replace('/```json|```/', '', $text);

        return json_decode(trim($clean), true) ?? [];
    }

    // ── 2. Find journals that contain at least one of the weighted terms ──
    private function getCandidates(array $weightedTerms): \Illuminate\Support\Collection
    {
        $terms = collect($weightedTerms)->pluck('term');

        return Journals::where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('condition', 'like', "%{$term}%")
                  ->orWhere('story', 'like', "%{$term}%");
            }
        })->with('user')->get();
    }

    // ── 3. Score each candidate by SWD and return ranked list ──
    private function rankJournals(\Illuminate\Support\Collection $candidates, array $weightedTerms): \Illuminate\Support\Collection
    {
        return $candidates->map(function ($journal) use ($weightedTerms) {
            $text       = strtolower($journal->condition . ' ' . $journal->story);
            $totalWords = max(str_word_count($text), 1);
            $score      = 0;

            foreach ($weightedTerms as $term) {
                $count  = substr_count($text, strtolower($term['term']));
                $score += $count * $term['semantic_weight'];
            }

            return [
                'journal' => $journal,
                'swd'     => $score / $totalWords,
            ];
        })->sortByDesc('swd')->values();
    }

    // ── 4. Feed top 5 journals to Gemini → returns persona as system prompt text ──
    private function buildPersona(string $description, \Illuminate\Support\Collection $rankedJournals): string
    {
        $topStories = $rankedJournals->take(5)
            ->map(fn($r) => $r['journal']->story)
            ->implode("\n\n---\n\n");

        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [[
                    'parts' => [[
                        'text' => "You are creating a system prompt for an AI character on Hive — a health platform.
This character is born entirely from real patient stories. It is NOT a medical bot.
It speaks in first person, warmly, like someone who has genuinely lived through this.

The user searched for: \"{$description}\"

These are the most relevant patient stories ranked by relevance:
{$topStories}

Write a system prompt that:
- Names the character based on the emotional texture of these stories
- Instructs it to speak as someone who has lived this experience
- Tells it to draw on the specific emotions and wisdom from the stories
- Tells it never to give clinical advice — only lived experience and empathy
- Keeps it conversational, warm, and human

Return ONLY the system prompt as plain text. No explanation. No JSON. No markdown."
                    ]]
                ]],
                'generationConfig' => ['temperature' => 0.85, 'maxOutputTokens' => 800]
            ]
        );

        return $response->json('candidates.0.content.parts.0.text') ?? '';
    }

    // ── Orchestrates all 4 steps and saves persona to chats table ──
    public function CreatePersona(Request $request)
    {
        $request->validate([
            'problem_description' => 'required|string',
        ]);

        $description   = $request->problem_description;

        $weightedTerms = $this->generateSemanticWeights($description);
        $candidates    = $this->getCandidates($weightedTerms);
        $ranked        = $this->rankJournals($candidates, $weightedTerms);
        $personaPrompt = $this->buildPersona($description, $ranked);

        $chat = Chats::create([
            'user'    => auth()->id(),
            'thread'  => json_encode([]),
            'persona' => $personaPrompt,
        ]);

        return redirect()->route('index');
    }
}