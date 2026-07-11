# Planner — Task Decomposition & Planning

## Responsibilities
- Prompt decomposition
- Complexity estimation
- Risk assessment
- Task classification
- Review requirements
- Rollback strategy

## Planning Output Structure
Every plan MUST contain:

```yaml
goal: "Clear description of what needs to be done"
complexity: "low | medium | high | critical"
risk: "none | low | medium | high"
affected_modules:
  - module_name
execution_order:
  - step_1
  - step_2
  - step_3
estimated_files:
  - file_path
testing_strategy: "How this will be tested"
rollback_strategy: "How to revert if needed"
estimated_tokens: "approximate token cost"
ai_review_required: true | false
```

## Complexity Estimation
| Level | Criteria |
|---|---|
| Low | Single file change, no new logic |
| Medium | 2-5 files, moderate new logic |
| High | Multiple modules, schema changes, new features |
| Critical | Architecture changes, migrations, breaking changes |

## Risk Assessment
- **None**: Trivial change, no side effects
- **Low**: Isolated change, well-understood
- **Medium**: Cross-module change, potential regressions
- **High**: Database schema, auth, security, payments

## Rollback Strategy
Always define how to revert:
- Git revert specific commits
- Database migration rollback
- Feature flag disable
- Config restore
