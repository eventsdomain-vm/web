# System Layer — Global Engineering Workflow

## Purpose
Defines the global engineering workflow for all AI agents. This file is the entry point for every prompt.

## Responsibilities
- Receive user prompts
- Enforce execution order
- Delegate to planner.md for decomposition
- Never store architecture
- Never store project memory
- Never store implementation details

## Stability
This file remains stable throughout the lifetime of the project. Do not modify unless the engineering workflow fundamentally changes.

## Entry Point
Every prompt MUST begin by reading this file and following the workflow defined in workflow.md.
