# Runtime — Task Classifier

## Purpose
Classify incoming user prompts before any work begins.

## Classification Dimensions

### Complexity
| Level | Indicators |
|---|---|
| Low | Single file change, boolean toggle, text change, config update |
| Medium | New feature in existing module, form addition, API endpoint |
| High | New module, schema migration, cross-role feature, integration |
| Critical | Architecture change, auth system, payment integration |

### Type
| Type | Examples |
|---|---|
| bug | Error in existing code, unexpected behavior |
| feature | New capability, new route, new component |
| refactor | Code restructuring without behavior change |
| config | Environment, settings, dependencies |
| documentation | Updating docs, memory files |
| design | UI/UX changes, layout, styling |
| review | Code review, audit, analysis |

### Risk
| Level | Indicators |
|---|---|
| None | No data, no auth, no schema |
| Low | Isolated, well-understood change |
| Medium | Cross-module, touches DB or auth |
| High | Migration, breaking change, payment |

## Output
```json
{
  "complexity": "medium",
  "type": "feature",
  "risk": "low",
  "estimated_files": 3,
  "estimated_tokens": "~2000",
  "ai_review_required": true
}
```

## Rules
- If complexity is CRITICAL: require explicit user approval before planning
- If risk is HIGH: require explicit user approval before execution
- If type is REVIEW: skip execution entirely, go directly to review
- If type is DOCUMENTATION: skip planning and execution
