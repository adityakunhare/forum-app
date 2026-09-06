# Forum App - Agent Guidelines

## Stack & Setup
- Laravel 12 + Inertia.js (Vue3) frontend with Vite
- Jetstream auth system, Tiptap WYSIWYG editor for post body editing
- MySQL database required; tests use SQLite unless configured otherwise (`DB_DATABASE=forum_test_db`)
```bash
# Full dev server: runs PHP+queue+vite in parallel terminals via Composer Concurrency plugin
composer run dev

# Individual commands when needed
php artisan serve
npm run dev           # Vite hot reload (opens browser)
npm run build         # Production asset compilation
vendor/bin/phpunit   # Run all tests
```

## Code Organization
- **`app/Http/Controllers/**`:** Post, Comment, Like controllers in `routes/web.php`; shallow comments resource creates per-post comment threads only.
- **`resources/views/Dashboard.tsx`, `resources/js/Pages/**`:** Vue SPA entrypoints; Inertia renders views via TypeScript components (check `.vue/.tsx`).
- **`database/schema/`:** Migrations in alphabetical order—run from oldest to newest: `./vendor/bin/knuckleswift:migrate && ./vendor/laravel/pail ...`.

## Testing Workflow
1. Copy `.env.example` → set `APP_ENV=testing`, override DB_DATABASE as needed (easiest with SQLite by commenting out MySQL lines): create database, seed if necessary before running tests: ````bash
    composer install
    cp .env.example .env && php artisan key:generate        # Basic setup for local dev/testing

2. Run PHPUnit test suite; use `--filter` to target specific tests and pass env vars or modify config files as needed (see below). Test coverage includes unit-level logic in **`tests/Unit/**`, feature suites cover HTTP integration scenarios across routes/resources, with factories located at **`database/factories/**`.

3. Static analysis & pre-commit gates: run these before committing to avoid CI failures; ````bash
    php artisan pint       # Enforce code style (PSR-12); check status via `lint --check`.

4. TailwindCSS + Postcss config exists but is rarely needed for day-to-day CSS development unless you need production build or specific plugins enabled by default in your project setup. Always run migrations (`php artisan migrate:fresh`) before adding new feature tests to ensure clean database state, especially when testing Eloquent model behavior across multiple related models/relationships (posts/comments/users).

## Style Rules
4-space indentation with spaces only; 120-char line width enforced by Pint formatter—use that tool rather than manual formatting. Always trim trailing whitespace before committing files (editor should be configured for this per `.gitignore(.editorconfig`).

```
# Behavioral guidelines

Behavioral guidelines to reduce common LLM coding mistakes. Merge with project-specific instructions as needed.

**Tradeoff:** These guidelines bias toward caution over speed. For trivial tasks, use judgment.

## 1. Think Before Coding

**Don't assume. Don't hide confusion. Surface tradeoffs.**

Before implementing:
- State your assumptions explicitly. If uncertain, ask.
- If multiple interpretations exist, present them - don't pick silently.
- If a simpler approach exists, say so. Push back when warranted.
- If something is unclear, stop. Name what's confusing. Ask.

## 2. Simplicity First

**Minimum code that solves the problem. Nothing speculative.**

- No features beyond what was asked.
- No abstractions for single-use code.
- No "flexibility" or "configurability" that wasn't requested.
- No error handling for impossible scenarios.
- If you write 200 lines and it could be 50, rewrite it.

Ask yourself: "Would a senior engineer say this is overcomplicated?" If yes, simplify.

## 3. Surgical Changes

**Touch only what you must. Clean up only your own mess.**

When editing existing code:
- Don't "improve" adjacent code, comments, or formatting.
- Don't refactor things that aren't broken.
- Match existing style, even if you'd do it differently.
- If you notice unrelated dead code, mention it - don't delete it.

When your changes create orphans:
- Remove imports/variables/functions that YOUR changes made unused.
- Don't remove pre-existing dead code unless asked.

The test: Every changed line should trace directly to the user's request.

## 4. Goal-Driven Execution

**Define success criteria. Loop until verified.**

Transform tasks into verifiable goals:
- "Add validation" → "Write tests for invalid inputs, then make them pass"
- "Fix the bug" → "Write a test that reproduces it, then make it pass"
- "Refactor X" → "Ensure tests pass before and after"

For multi-step tasks, state a brief plan:
```
1. [Step] → verify: [check]
2. [Step] → verify: [check]
3. [Step] → verify: [check]
```

Strong success criteria let you loop independently. Weak criteria ("make it work") require constant clarification.

---

**These guidelines are working if:** fewer unnecessary changes in diffs, fewer rewrites due to overcomplication, and clarifying questions come before implementation rather than after mistakes.
```