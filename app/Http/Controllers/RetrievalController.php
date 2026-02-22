<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetrievalController extends Controller
{

//     public function getCandidates($weightedTerms){
//         $terms = collect($weightedTerms)->pluck('term');

//         $query = Journal::query();

//         $query->where(function ($q) use ($terms) {
//             foreach ($terms as $term) {
//                 $q->orWhere('condition', 'like', "%{$term}%")
//                 ->orWhere('story', 'like', "%{$term}%");
//             }
// });

//         $candidates = $query->get();
//         return $candidates;
//     }

//    public function calculateWeightedDensity($journal, $weightedTerms)
// {
//     $text = strtolower($journal->condition . ' ' . $journal->story);
//     $totalWords = str_word_count($text);
//     $score = 0;

//     foreach ($weightedTerms as $term) {
//         $count = substr_count($text, strtolower($term['term']));
//         $score += $count * $term['weight'];
//     }

//     return $score / max($totalWords, 1);
// }
}
