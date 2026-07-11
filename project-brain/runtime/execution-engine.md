# Runtime — Execution Engine

## Purpose
Generate implementation changes after planning is approved.

## Responsibilities
- Modify code according to plan
- Respect project standards (standards/*.md)
- Avoid unrelated refactoring
- Preserve architecture defined in memory/architecture.md
- No review occurs during execution

## Rules
1. Read relevant memory files first via Context Loader
2. Read the specific files to be modified
3. Make targeted changes — minimal diff
4. Follow standards/*.md conventions
5. Do NOT refactor unrelated code
6. Do NOT add comments unless required by standards
7. Do NOT add features beyond the plan scope

## Validation Before Proceeding
After execution, always run:
```bash
php artisan pint --test
php artisan route:list > /dev/null 2>&1
npm run build 2>&1 | tail -5
```
If any fail → fix immediately, then proceed to Static Validation.
