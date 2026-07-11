# Runtime — Review Engine

## Purpose
Evaluate implementation quality after static validation passes.

## Evaluation Areas
| Area | Weight | Description |
|---|---|---|
| Architecture | 20% | Does it match the defined architecture? |
| Maintainability | 15% | Is it easy to understand and modify? |
| Readability | 10% | Is the code clean and self-documenting? |
| Intent Matching | 20% | Does it solve the exact problem? |
| Side Effects | 15% | Could it break other features? |
| Scalability | 10% | Will it perform at scale? |
| Regression Risk | 10% | What is the risk of regressions? |

## Scoring
Each area scored 0-100. Overall = weighted average.

Acceptance: Overall ≥ 90

## If Score < 90
1. Identify lowest-scoring areas
2. Provide specific improvement recommendations
3. Return to execution phase
4. Re-review after fixes

## If Score ≥ 90
Proceed to Knowledge Synchronization.

## Output Format
```yaml
architecture: 96
maintainability: 92
readability: 95
intent_matching: 98
side_effects: 94
scalability: 91
regression_risk: 93
overall: 94
accepted: true
recommendations:
  - "Consider extracting X into a separate method"
  - "Add test coverage for edge case Y"
```
