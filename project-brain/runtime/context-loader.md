# Runtime — Context Loader

## Purpose
Load only the minimum context required for a task based on graph retrieval results.

## Behavior
1. Receives affected nodes from Graph Retriever
2. Maps nodes to memory files
3. Loads only those memory files into context
4. Never loads memory files outside the affected scope

## Node-to-Memory Mapping
| Graph Node | Memory File |
|---|---|
| Event, EventController, EventService | backend.md, database.md, routing.md |
| Sponsor, SponsorController | backend.md, routing.md |
| Partner, PartnerService | backend.md, database.md |
| Admin, AdminController | backend.md, routing.md |
| Message, Chat | api.md, database.md |
| Category | database.md |
| Dashboard | frontend.md, routing.md |
| Search | api.md, database.md |
| RoiCalculator | api.md |
| Auth | backend.md, routing.md |
| Any Blade component | frontend.md |
| Any migration | database.md |

## Cache
- Recent context stored in cache/recent-context.md
- Cache invalidated after 3 prompts or context switch
