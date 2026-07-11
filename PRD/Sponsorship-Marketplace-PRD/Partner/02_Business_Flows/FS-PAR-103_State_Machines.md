# FS-PAR-103 State Machines

**Module ID:** FS-PAR-103

**Document Name:** State Machines

**Version:** 1.0

**Status:** Draft

**Owner:** Product Team

---

# Table of Contents

1. Introduction
2. Purpose
3. State Machine Framework
4. Common State Rules
5. Client State Machine
6. Opportunity State Machine
7. Lead State Machine
8. Deal State Machine
9. Contract State Machine
10. Campaign State Machine
11. Meeting State Machine
12. Task State Machine
13. Commission State Machine
14. Payment State Machine
15. Document State Machine
16. Cross-Entity Dependencies
17. Notification Triggers
18. Audit Requirements
19. Business Rules
20. Related Documents

---

# 1. Introduction

## Purpose

This document defines the lifecycle of all major business entities managed within the Partner Workspace.

A state machine specifies:

- Valid states
- Allowed transitions
- Transition triggers
- Entry criteria
- Exit criteria
- Validation rules
- Exception handling

No business entity may transition outside the rules defined in this document.

---

# 2. Purpose

The state machines provide a single source of truth for:

- Workflow execution
- UI behavior
- Backend validation
- API contracts
- Automation
- Notifications
- Audit logging
- Reporting

---

# 3. State Machine Framework

Every entity follows a common lifecycle model.

```
Created
    │
    ▼
Active
    │
    ▼
In Progress
    │
    ▼
Completed
    │
    ▼
Archived
```

Additional states may be introduced based on business requirements.

---

# 4. Common State Rules

All entities follow these principles:

- Initial state is assigned automatically.
- Transitions must be explicitly validated.
- Invalid transitions are rejected.
- State changes generate audit events.
- State changes may trigger notifications.
- Some transitions require approvals.
- Closed or archived records are read-only unless reopened through an authorized workflow.

---

# 5. Client State Machine

## Lifecycle

```
Prospect
    │
    ▼
Qualified
    │
    ▼
Active
    │
    ├──────────────► Inactive
    │                     │
    ▼                     ▼
Renewal             Reactivated
    │
    ▼
Archived
```

### States

| State | Description |
|--------|-------------|
| Prospect | Newly identified organization |
| Qualified | Meets business criteria |
| Active | Actively engaged client |
| Inactive | No recent engagement |
| Renewal | Under renewal discussion |
| Reactivated | Returned to active business |
| Archived | Permanently closed |

### Transition Rules

- Prospect → Qualified requires qualification.
- Qualified → Active requires onboarding.
- Active → Renewal requires an active relationship nearing completion.
- Inactive → Reactivated requires new engagement.

---

# 6. Opportunity State Machine

```
Discovered
    │
    ▼
Saved
    │
    ▼
Recommended
    │
    ▼
Accepted
    │
    ▼
Converted to Lead
    │
    ▼
Closed
```

### Invalid Transitions

- Saved → Closed
- Discovered → Converted
- Closed → Recommended

---

# 7. Lead State Machine

```
New
    │
    ▼
Contacted
    │
    ▼
Qualified
    │
    ▼
Proposal Sent
    │
    ▼
Negotiation
    ├────────────► Lost
    │
    ▼
Won
    │
    ▼
Converted to Deal
```

### Entry Criteria

- Opportunity selected
- Client assigned

### Exit Criteria

- Deal created
- Lead archived

---

# 8. Deal State Machine

```
Draft
    │
    ▼
Internal Review
    │
    ▼
Client Review
    │
    ▼
Negotiation
    │
    ▼
Approved
    │
    ▼
Contract Created
    │
    ▼
Closed Won
```

### Alternative Path

```
Negotiation
      │
      ▼
Closed Lost
```

### Rules

- Only approved deals can generate contracts.
- Closed Won deals cannot return to Draft.
- Closed Lost deals require a loss reason.

---

# 9. Contract State Machine

```
Draft
    │
    ▼
Internal Review
    │
    ▼
Sponsor Review
    │
    ▼
Organizer Review
    │
    ▼
Signed
    │
    ▼
Active
    │
    ▼
Completed
    │
    ▼
Archived
```

### Exception

```
Any State
      │
      ▼
Cancelled
```

Cancellation requires an authorized approval.

---

# 10. Campaign State Machine

```
Planned
    │
    ▼
Scheduled
    │
    ▼
Active
    │
    ▼
Monitoring
    │
    ▼
Completed
    │
    ▼
Closed
```

### Exception

```
Scheduled
     │
     ▼
Cancelled
```

---

# 11. Meeting State Machine

```
Draft
    │
    ▼
Scheduled
    │
    ▼
Confirmed
    │
    ▼
In Progress
    │
    ▼
Completed
```

### Alternate States

- Rescheduled
- Cancelled
- No Show

---

# 12. Task State Machine

```
Created
    │
    ▼
Assigned
    │
    ▼
In Progress
    │
    ▼
Completed
```

### Alternate States

- Blocked
- Cancelled
- Deferred

---

# 13. Commission State Machine

```
Pending
    │
    ▼
Calculated
    │
    ▼
Finance Review
    │
    ▼
Approved
    │
    ▼
Released
    │
    ▼
Paid
```

### Exception

```
Approved
     │
     ▼
Disputed
     │
     ▼
Resolved
```

### Rules

- Commission cannot reach Paid without Released.
- Finance approval is mandatory before release.

---

# 14. Payment State Machine

```
Initiated
    │
    ▼
Pending
    │
    ▼
Processing
    │
    ▼
Completed
```

### Alternate States

- Failed
- Refunded
- Cancelled

### Rules

- Completed payments cannot be edited.
- Refunds require authorization.

---

# 15. Document State Machine

```
Uploaded
    │
    ▼
Verified
    │
    ▼
Approved
    │
    ▼
Active
```

### Alternate States

- Rejected
- Expired
- Archived

### Examples

- NDA
- Proposal
- Contract
- Invoice
- Presentation

---

# 16. Cross-Entity Dependencies

Entity transitions are interdependent.

| Source Entity | Dependency | Target Entity |
|---------------|------------|---------------|
| Opportunity | Accepted | Lead |
| Lead | Won | Deal |
| Deal | Approved | Contract |
| Contract | Active | Campaign |
| Campaign | Completed | Commission |
| Payment | Completed | Commission Release |

A downstream entity cannot advance until its prerequisite entity reaches the required state.

---

# 17. Notification Triggers

State changes generate notifications.

Examples:

| Entity | Transition | Notification |
|---------|------------|--------------|
| Lead | Qualified | Notify Manager |
| Deal | Approved | Notify Finance |
| Contract | Signed | Notify Account Manager |
| Campaign | Active | Notify Stakeholders |
| Commission | Approved | Notify Finance Executive |
| Payment | Completed | Notify Partner Owner |

Notification delivery channels:

- In-App
- Email
- Push
- SMS (optional)
- WhatsApp (optional)

---

# 18. Audit Requirements

Every state transition must record:

- Entity ID
- Previous State
- New State
- Timestamp
- User
- Trigger Source (User/System/API)
- Approval Reference (if applicable)
- Comments

Audit records are immutable and retained according to platform retention policies.

---

# 19. Business Rules

- Every entity has exactly one active state.
- Invalid transitions are rejected.
- Required approvals must be completed before protected transitions.
- Closed and Archived entities are read-only unless reopened through an authorized process.
- Automated workflows may initiate transitions only where explicitly configured.
- State changes trigger activity timeline entries.
- Reports use state history for analytics and SLA calculations.
- APIs must validate state transitions before persisting changes.

---

# 20. Related Documents

## Foundation

- FS-PAR-001_Partner_Workspace.md
- FS-PAR-004_User_Roles.md
- FS-PAR-005_Workspace_Architecture.md

## Business Flows

- FS-PAR-101_Partner_Flow.md
- FS-PAR-102_User_Journeys.md
- FS-PAR-104_Sequence_Diagrams.md
- FS-PAR-105_Data_Flow.md

## Technical

- Permission_Matrix.md
- API_Specification.md
- Database_Model.md
- Notification_Matrix.md

## Module Specifications

- Leads.md
- Deals.md
- Meetings.md
- Commission.md
- Reports.md