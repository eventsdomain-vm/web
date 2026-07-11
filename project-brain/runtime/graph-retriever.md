# Runtime — Graph Retriever

## Purpose
Determine the minimum context required by finding affected nodes and their dependencies.

## Behavior
```
Find affected nodes
    ↓
Resolve dependencies
    ↓
Return connected files
    ↓
Return APIs
    ↓
Return Routes
    ↓
Return Components
```

## Graph Source
`graph/graph.json` — maintained by Graphify, never manually edited.

## Output Format
```json
{
  "task": "description",
  "primary_nodes": ["NodeA", "NodeB"],
  "dependencies": ["NodeC", "NodeD"],
  "memory_files": ["backend.md", "database.md"],
  "routes_affected": ["GET /events", "POST /events"],
  "components_affected": ["event-card", "event-form"],
  "estimated_context": "~300 lines"
}
```

## Fallback
If graph.json does not exist or is empty, use this heuristic:
1. Extract nouns from user prompt
2. Map to known module names
3. Load the corresponding memory files
