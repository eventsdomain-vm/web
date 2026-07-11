# Technical Specification (TS)

# TS-SPO-001 — Sponsor Workspace Technical Specification

---

# Part 2 — Backend Design

---

# Table of Contents

13. Data Model
14. Database Schema
15. API Specifications
16. Authentication
17. Authorization
18. Permission Matrix
19. Validation Rules
20. Business Rules
21. Workflow Specifications
22. State Machines

---

# 13. Data Model

## Purpose

The Sponsor Workspace follows a modular, domain-driven data model where each business capability owns its entities while maintaining referential integrity through well-defined relationships.

The model is optimized for:

- High-performance querying
- Normalized relational data
- Auditability
- Soft deletion
- Event sourcing compatibility
- Future multi-tenancy
- Horizontal scalability

---

## Core Business Domains

```text
Sponsor Workspace

├── Organization
├── Users
├── Teams
├── Opportunities
├── Applications
├── Negotiations
├── Deals
├── Campaigns
├── Deliverables
├── Brand Assets
├── Budgets
├── Contracts
├── Invoices
├── Payments
├── Reports
├── Notifications
├── Audit Logs
└── Settings
```

---

## Entity Relationship Overview

```text
Organization
      │
      ├──────── Users
      │            │
      │            ├──── Teams
      │            ├──── Roles
      │            └──── Permissions
      │
      ├──────── Opportunities
      │                │
      │                ├──── Saved Opportunities
      │                ├──── Notes
      │                ├──── Ratings
      │                └──── Risk Assessments
      │
      ├──────── Applications
      │                │
      │                ├──── Documents
      │                ├──── Approvals
      │                └──── Timeline
      │
      ├──────── Deals
      │                │
      │                ├──── Negotiations
      │                ├──── Contracts
      │                └──── Activities
      │
      ├──────── Campaigns
      │                │
      │                ├──── Deliverables
      │                ├──── Milestones
      │                ├──── Assets
      │                └──── Calendar
      │
      ├──────── Finance
      │                ├──── Budgets
      │                ├──── Invoices
      │                ├──── Payments
      │                └──── Tax Documents
      │
      └──────── Analytics
                       ├──── ROI
                       ├──── KPIs
                       └──── Reports
```

---

## Common Model Standards

Every primary entity contains:

```text
id (ULID)
organization_id
created_by
updated_by
deleted_by
created_at
updated_at
deleted_at
```

---

## Audit Fields

Every business entity stores:

- Creator
- Last Modifier
- Soft Delete User
- Created Timestamp
- Updated Timestamp
- Deleted Timestamp

---

## Primary Relationships

| Parent | Child | Relationship |
|---------|-------|-------------|
| Organization | Users | One-to-Many |
| User | Applications | One-to-Many |
| Opportunity | Applications | One-to-Many |
| Application | Negotiation | One-to-One |
| Negotiation | Deal | One-to-One |
| Deal | Campaign | One-to-One |
| Campaign | Deliverables | One-to-Many |
| Campaign | Assets | One-to-Many |
| Budget | Payments | One-to-Many |
| Contract | Invoices | One-to-Many |

---

# 14. Database Schema

## Database Engine

- MySQL 8+
- InnoDB
- UTF8MB4 Character Set
- UTC Timestamps

---

## Naming Convention

| Object | Convention |
|----------|------------|
| Tables | snake_case plural |
| Columns | snake_case |
| Foreign Keys | *_id |
| Pivot Tables | alphabetical |

---

## Example Tables

### organizations

```sql
id
name
legal_name
industry
website
currency
timezone
status

created_at
updated_at
deleted_at
```

---

### users

```sql
id
organization_id
role_id

name
email
password

phone
avatar

status

last_login_at

created_at
updated_at
deleted_at
```

---

### opportunities

```sql
id

organizer_id

title

slug

category

event_type

location

budget_min

budget_max

visibility

status

published_at

created_at

updated_at

deleted_at
```

---

### applications

```sql
id

opportunity_id

organization_id

submitted_by

application_number

status

submitted_at

approved_at

created_at

updated_at
```

---

### campaigns

```sql
id

deal_id

name

status

start_date

end_date

budget

created_at

updated_at
```

---

## Database Standards

- Foreign Keys enforced
- Soft Deletes
- Composite Indexes
- Full-text Search Indexes
- Optimistic Locking (future)
- Database Transactions

---

## Index Strategy

Indexes added for:

- Search
- Status
- Foreign Keys
- Dates
- Visibility
- Ownership

---

# 15. API Specifications

## API Architecture

RESTful JSON APIs

Versioning:

```text
/api/v1/
```

---

## Authentication

Laravel Sanctum

Bearer Token

HTTPS Required

---

## Response Format

Success

```json
{
    "success": true,
    "message": "Operation successful.",
    "data": {}
}
```

---

Validation Error

```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {}
}
```

---

Server Error

```json
{
    "success": false,
    "message": "Internal Server Error"
}
```

---

## API Standards

Supports:

- Pagination
- Filtering
- Sorting
- Searching
- Field Selection
- Includes
- Rate Limiting

---

## Example Endpoints

### Opportunities

```http
GET /api/v1/opportunities

GET /api/v1/opportunities/{id}

POST /api/v1/opportunities

PUT /api/v1/opportunities/{id}

DELETE /api/v1/opportunities/{id}
```

---

### Applications

```http
GET /applications

POST /applications

PATCH /applications/{id}

DELETE /applications/{id}
```

---

### Campaigns

```http
GET /campaigns

POST /campaigns

PATCH /campaigns/{id}
```

---

# 16. Authentication

## Framework

Laravel Authentication

Laravel Sanctum

---

## Login Methods

- Email
- Password
- SSO
- MFA (future)

---

## Password

Uses:

```php
Hash::make()
```

---

## Session

Supports

- Session Timeout
- Remember Me
- Concurrent Sessions
- Device Tracking

---

## Password Policies

- Minimum 12 Characters
- Complexity
- Password History
- Expiration
- Lockout

---

# 17. Authorization

Authorization uses Laravel Policies.

Every business entity has a Policy.

Example

```text
OpportunityPolicy

ApplicationPolicy

CampaignPolicy

DealPolicy

BudgetPolicy

InvoicePolicy
```

---

## Gates

Global Gates

```php
isAdmin

isExecutive

canApprove

canManageFinance
```

---

## Middleware

```text
auth

verified

permission

role

organization

signed
```

---

# 18. Permission Matrix

Example

| Module | View | Create | Update | Delete | Approve |
|---------|------|---------|----------|----------|-----------|
| Opportunities | ✔ | ✔ | ✔ | ✔ | — |
| Applications | ✔ | ✔ | ✔ | — | ✔ |
| Campaigns | ✔ | ✔ | ✔ | ✔ | ✔ |
| Finance | ✔ | — | ✔ | — | ✔ |
| Reports | ✔ | — | — | — | — |

---

## Role Strategy

Roles

- Admin
- Executive
- Sponsorship Manager
- Finance
- Legal
- Marketing
- Team Member
- Viewer

---

# 19. Validation Rules

Validation uses Laravel Form Requests.

Example

```php
StoreOpportunityRequest

UpdateCampaignRequest

StoreInvoiceRequest
```

---

## Rules

```text
required

nullable

string

integer

numeric

boolean

email

url

uuid

date

array

exists

unique

confirmed
```

---

## Business Validation

Examples

Budget

```text
Minimum Budget <= Maximum Budget
```

Campaign

```text
End Date > Start Date
```

Payment

```text
Invoice must exist
```

Contract

```text
Deal must be approved
```

---

# 20. Business Rules

Business logic resides inside Services.

Never inside Controllers.

Example

```text
OpportunityService

ApplicationService

CampaignService

FinanceService

AnalyticsService
```

---

## Transaction Rules

Critical operations use

```php
DB::transaction()
```

Examples

- Submit Application
- Approve Budget
- Execute Contract
- Record Payment

---

## Event Driven Rules

Example

```text
Application Submitted

↓

Notify Organizer

↓

Create Timeline

↓

Log Activity

↓

Update Dashboard
```

---

# 21. Workflow Specifications

Every workflow has defined states.

Example

Application

```text
Draft

↓

Submitted

↓

Under Review

↓

Negotiation

↓

Approved

↓

Contract

↓

Completed
```

---

Campaign

```text
Planning

↓

Active

↓

Paused

↓

Completed

↓

Archived
```

---

Budget

```text
Draft

↓

Requested

↓

Approved

↓

Allocated

↓

Consumed

↓

Closed
```

---

# 22. State Machines

State transitions are enforced within the service layer to prevent invalid workflow changes.

---

## Opportunity

```text
Draft
   │
Published
   │
Open
   │
Closing
   │
Closed
   │
Archived
```

---

## Application

```text
Draft
   │
Submitted
   │
Review
   │
Negotiation
   │
Approved
   │
Rejected
```

---

## Deal

```text
Open
   │
Negotiation
   │
Agreement
   │
Contract Signed
   │
Campaign Started
   │
Completed
```

---

## Campaign

```text
Planning
   │
Ready
   │
Active
   │
Paused
   │
Completed
   │
Archived
```

---

## Payment

```text
Pending
   │
Approved
   │
Processing
   │
Paid
   │
Failed
   │
Refunded
```

---

## Deliverables of Part 2

This section defines the backend implementation standards for the Sponsor Workspace, including the domain model, relational database design, REST API conventions, authentication and authorization mechanisms, validation strategy, business logic organization, workflow orchestration, and lifecycle state management.

**Part 3 — Enterprise Architecture** will cover:

- Notifications
- Queues & Jobs
- Events & Listeners
- Error Handling
- Logging & Audit
- Performance Requirements
- Security
- Testing Strategy
- Deployment
- Monitoring
- Acceptance Criteria
- Future Roadmap

This completes the technical implementation blueprint required before development begins.