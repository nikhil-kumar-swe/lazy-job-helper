# Lazy Job-Application Helper

Paste your resume and a job description. Gemma gives you a tailored cover letter, the keywords your resume is missing, a few resume bullet rewrites, and five likely interview questions. Everything is saved to a private history page.

Built for the **DEV Hacktoberfest Open-Source AI Challenge: Week 3 ("Slow and Steady")**. The theme is open-weight AI that does a dreaded task for you, and writing job applications is mine.

- Repo: https://github.com/nikhil-kumar-swe/lazy-job-helper

## What it does

1. Sign up and log in (Laravel Breeze).
2. Paste your resume as plain text and paste the job description.
3. A hosted Gemma model returns:
   - a tailored cover letter
   - missing keywords (things the job asks for that your resume does not show)
   - 3 to 5 rewritten resume bullets
   - 5 interview questions
4. Results are saved. You can view or delete them from the History page.

**Suggestions only.** It does not generate a full resume, and it does not apply to jobs for you. Check every line against your real experience before using it.

### The honesty rule

The prompt tells the model to use only facts found in the resume and never to invent skills, tools, employers or numbers. I tested this with sample resumes and compared the output against the source text. Early prompts added filler words and small claims, so I tightened the prompt in several rounds. The final version keeps numbers exactly as written and rewords bullets without adding new facts. The tradeoff: the rewrites stay fairly close to your original wording.

## Model and open-source AI

- Model: **Gemma** (`gemma-4-31b-it`), an open-weight model from Google.
- Served through the Gemini API on Google AI Studio (free tier).
- All model calls live in one class, `app/Services/ModelClient.php`. The API key, URL and model name come from `.env`:

```
GEMMA_API_KEY=
GEMMA_API_URL=https://generativelanguage.googleapis.com/v1beta/models
GEMMA_MODEL=gemma-4-31b-it
```

Switching to another Gemma model on the same API only needs a `.env` change. Switching to a different provider means editing only `ModelClient.php`, because the request and response format would change.

## Privacy (please read)

This is **not** a private or offline app.

- Resume and job text are sent to Google's hosted API.
- On Google's free tier, Google may use prompts and responses to improve its products.
- Do not paste phone numbers, home addresses or ID numbers. The form shows this warning.
- There is no automatic redaction in this version.
- Because Gemma is open-weight, it could be run locally (for example with Ollama) to keep text on your own machine. I did not build or test that.

Other protections that are in place:
- Each user can only open and delete their own applications (other users get a 404).
- Submissions are rate limited to 5 per minute.
- Resume text is not written to the logs, and API keys are never committed (`.env` is git-ignored).

## Tech stack

- Laravel with Breeze, Blade and Tailwind CSS
- SQLite for local development
- Gemma via the Gemini API

## Run it yourself

You need PHP, Composer, Node.js and npm.

```
git clone https://github.com/nikhil-kumar-swe/lazy-job-helper.git
cd lazy-job-helper
composer install
cp .env.example .env
php artisan key:generate
```

Open `.env` and set `GEMMA_API_KEY` (get a key at aistudio.google.com). Then:

```
php artisan migrate
npm install
npm run build
php artisan serve
```

Open http://127.0.0.1:8000, register, and click **New Application**.

If `GEMMA_MODEL` returns a "not found" error, list the models your key can use:

```
curl "https://generativelanguage.googleapis.com/v1beta/models" -H "x-goog-api-key: YOUR_KEY"
```

## Known limits

- A request can take up to about 2 minutes on the free tier. The button shows "Generating..." while you wait.
- Free-tier quotas can change, and the API sometimes returns temporary errors. The app retries a few times and then shows a friendly error message.
- Each text field is limited to 6000 characters.
- The bullet suggestions are rewrites of lines already in your resume, not new content.
- If the model returns invalid JSON, the app retries once. That path is built but only lightly tested.
- There is no live deployment. The demo is a screen recording.
- Not built: full resume generation, PDF export, file uploads, user profiles.

## Challenge notes

- The repository was started and finished during the challenge window (Oct 19 to Oct 25, 2026).
- Commits after the deadline: none
- AI tools were used to help plan the build and debug it.
- Prize category entered: Best Use of Gemma.
