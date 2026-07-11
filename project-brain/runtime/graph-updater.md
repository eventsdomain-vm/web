# Runtime — Graph Updater

## Purpose
Incrementally update graph relationships after a task is accepted.

## Rules
- Only update affected nodes and edges
- Never regenerate entire graph
- Graph is maintained programmatically — never manually edit graph/*.json

## Update Types
- Add node: New model, controller, service, component
- Add edge: New relationship, route, dependency
- Remove node: Deprecated module
- Remove edge: Removed connection

## Output Files
| File | Purpose |
|---|---|
| graph/graph.json | Main graph with nodes and edges |
| graph/nodes.json | All node definitions |
| graph/edges.json | All edge relationships |
| graph/graph-index.json | Searchable index |
| graph/embeddings.json | Semantic embeddings (future) |
