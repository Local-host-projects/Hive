> *The collected wisdom of everyone who has survived what you're going through — given a voice.*

Hive is a patient-powered health platform where lived experience becomes an AI character you can talk to. Built for the **Cavista Hackathon 2026** under the theme *"From Data to Prevention: AI as Your Health Partner."*

---

## The Problem

When you get diagnosed with something, the scariest part isn't always the condition itself. It's the silence after. The *"what now."*

You search the internet and find clinical articles written for doctors. You find forums full of strangers you can't verify. You find statistics with no face, no voice, no story behind them.

You are not looking for information. **You are looking for someone who has been there.**

That person exists. Thousands of them do. Their wisdom is scattered, unstructured, and inaccessible — locked inside personal blogs, Reddit threads, and private conversations.

Healthcare has digitised records. It has not digitised experience. **Hive does.**

---

## What Hive Does

Patients log their real journeys with illness — symptoms, treatments, coping strategies, emotional arc, and where they ended up. That data builds a living knowledge base grounded entirely in human stories.

When you search a condition, you don't get a list of articles.

**You get a character** — an AI persona synthesized from every story ever logged about that condition. It speaks in first person. It carries emotional memory. You have a real conversation with it.

That character has **alter egos** — distinct voices representing different outcome paths:

- Someone who recovered
- Someone managing it long term  
- Someone still in the middle of it right now

Each alter ego is **named dynamically** — its identity emerges from the emotional texture of the stories that formed it. No two conditions produce the same personas because no two conditions feel the same.

---

## How It Works

### 1. Patients Log Their Stories
Users contribute journal entries: condition, their story in their own words, and where they are now (active / chronic / recovered). No clinical structure imposed — just honest human writing.

### 2. Weighted Search
When a query comes in, Hive calls Gemini to expand it into **15 semantically weighted terms** — each token assigned a significance score from 1–10 based on medical and emotional relevance.

```json
[
  {"term": "blood sugar", "semantic_weight": 10},
  {"term": "insulin", "semantic_weight": 9},
  {"term": "exhausted", "semantic_weight": 6},
  {"term": "scared", "semantic_weight": 5}
]
```

Every journal in the database is then scored by **Semantic Weight Density (SWD)**:

```
SWD = Σ(term_occurrences × semantic_weight) / total_word_count
```

This rewards stories that are *dense* with relevant signal — not just stories that mention a term once in passing. Journals are ranked by SWD into a stack.

This is meaningfully different from standard retrieval. TF-IDF and BM25 weight by statistical frequency — how often a term appears relative to the corpus. Weighted search assigns weights by **semantic significance** — encoding medical and emotional knowledge directly into the query. The model decides what matters before it ever touches a document.

### 3. Character Synthesis
The top 5 ranked stories are fed to Gemini with a synthesis prompt. The output is not a chatbot with a database behind it — it is a **system prompt that becomes a living identity**, distilled from the specific cluster of human experiences that ranked highest for this query.

The persona is stored directly in the chat record and governs every subsequent message in the conversation.

### 4. Alter Ego Generation
Stories are clustered by outcome. Each cluster is synthesized into a distinct alter ego voice. The names are not assigned — they are **generated from the emotional fingerprint** of each cluster. A recovery cluster full of slow, hard-won progress births a different name than one full of sudden remission.

### 5. The Conversation
The user meets the main character first, then chooses an alter ego that matches where they are. The chat continues with that alter ego's system prompt as its identity — warm, personal, and grounded in real human stories.

---

## Prevention Angle

Hive is not reactive. The stories in the database reveal patterns — what people noticed before things got serious, what early interventions made the difference, what they wish they'd known at the start.

When you talk to a character before you even have a diagnosis, you are receiving the preventive wisdom of everyone who came before you. **That is prevention — not a feature, but the architecture.**

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Database | MySQL |
| AI | Google Gemini 1.5 Flash |
| Retrieval | Custom Weighted Search (SWD scoring) |
| Frontend | Blade + Vanilla JS (glassmorphism UI) |

---

## Architecture

```
User Query
    │
    ▼
Gemini → 15 Weighted Terms [{term, semantic_weight}]
    │
    ▼
MySQL → Candidate Journals (LIKE match on condition + story)
    │
    ▼
SWD Scorer → Ranked Journal Stack
    │
    ▼
Gemini → Character Synthesis (top 5 stories → system prompt)
    │
    ▼
Chat Record (persona stored as system prompt)
    │
    ▼
User ↔ Alter Ego Conversation
```

---

## Database Schema

```sql
users
  id, username, email, password, timestamps

journals
  id, user (fk), condition (string), story (text), timestamps

chats
  id, user (fk), thread (json), persona (text), timestamps
```

---

## Getting Started

```bash
git clone https://github.com/yourusername/hive.git
cd hive

composer install
cp .env.example .env

# Add your Gemini API key to .env
GEMINI_API_KEY=your_key_here

php artisan key:generate
php artisan migrate
php artisan db:seed --class=HiveSeeder

php artisan serve
```

---

## Key Endpoints

```
POST /persona/create       — Generate weighted search + synthesize character
GET  /journals             — Browse all patient stories (infinite scroll)
POST /journals             — Submit a new journal entry
GET  /journals/{id}        — Read a single story
GET  /chats/{id}           — Load a chat session
POST /chats/{id}/message   — Send a message to the character
```

---

## The Weighted Search — Why It Matters

Standard RAG retrieves documents and hands them to the model. The model answers. The retrieval is static, happens once, and cannot improve.

Weighted search encodes **what matters** before retrieval begins. The query is not a string — it is a ranked hierarchy of meaning. A story that mentions "insulin resistance" five times in a hundred words scores higher than one that mentions it once in a thousand. Signal density beats signal presence.

Because the weights are AI-generated per query rather than statistically computed from the corpus, they carry **semantic and contextual knowledge** that frequency-based methods cannot. The system understands that "exhausted" and "chronic fatigue" are the same signal. That "scared" is diagnostically meaningful even though it's not a medical term.

This is the retrieval layer. What it feeds — the character synthesis — is where Hive becomes something that has not existed before.

---

