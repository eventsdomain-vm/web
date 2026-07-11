# Runtime — Memory Updater

## Purpose
Incrementally update memory files after a task is accepted.

## Rules
- Only update affected files — never regenerate entire documentation
- Possible update targets:
  - memory/overview.md (if new module added)
  - memory/architecture.md (if architecture changed)
  - memory/backend.md (if new service/controller/model added)
  - memory/frontend.md (if new component/route added)
  - memory/database.md (if new migration added)
  - memory/routing.md (if routes changed)
  - memory/api.md (if API endpoints changed)
  - memory/dependencies.md (if dependencies added/removed)
  - memory/patterns.md (if new pattern established)

## Process
1. Determine which memory files are affected by the change
2. Read the current file
3. Append or modify only the affected section
4. Keep file under 500 lines
5. Do not change unrelated content

## After Update
- Update tasks/completed.md with entry
- Signal Graph Updater to update graph/graph.json
