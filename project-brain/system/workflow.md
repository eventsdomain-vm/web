# Workflow — Execution Lifecycle

No stage may be skipped. No implementation logic should exist inside this file.

## Pipeline

```
User Prompt
    ↓
Task Classification
    ↓
Graph Retrieval
    ↓
Context Loading
    ↓
Planning
    ↓
Execution
    ↓
Static Validation
    ↓
AI Review
    ↓
Confidence Scoring
    ↓
Knowledge Synchronization
    ↓
Response
```

## Stage Details

### 1. Task Classification
Read planner.md. Classify task by complexity, risk, and type.

### 2. Graph Retrieval
Query graph/graph.json for affected nodes, dependencies, and connected files.

### 3. Context Loading
Load only relevant memory files based on graph results. Never load everything.

### 4. Planning
Produce a structured plan using planner.md format. Do not write code yet.

### 5. Execution
Implement changes. Respect project standards. Avoid unrelated refactoring.

### 6. Static Validation
Run deterministic tooling before consuming AI review tokens:
- npm run lint
- php artisan test (or equivalent)
- npm run build
Fix all validation errors before proceeding.

### 7. AI Review
Only begins after static validation succeeds. Evaluate:
- Architecture, Maintainability, Readability
- Intent Matching, Side Effects
- Scalability, Regression Risk

### 8. Confidence Scoring
Score must be ≥ 90 overall. If below, return to execution.

### 9. Knowledge Synchronization
Update only affected memory files. Never regenerate entire documentation.

## Referenced Documents
- system/system.md — Entry point
- system/planner.md — Decomposition rules
- runtime/* — Execution engine components
