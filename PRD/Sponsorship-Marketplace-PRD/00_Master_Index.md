# 00_Master_Index.md

# Sponsorship Marketplace Platform (SMP)
## Master Documentation Index

**Version:** 1.0.0  
**Status:** Draft  
**Last Updated:** July 2026

---

# Purpose

This document serves as the central navigation point for the entire Product Requirements Document (PRD) repository.

It provides:

- Repository structure
- Module hierarchy
- Feature identification (Feature IDs)
- Screen identification (Screen IDs)
- API module mapping
- Database module mapping
- User role mapping
- Development phases
- Documentation standards
- Cross-reference matrix

Every document in this repository references the IDs defined here.

---

# Repository Structure

```
Sponsorship-Marketplace-PRD/
│
├── README.md
├── 00_Master_Index.md
├── 01_Product_Vision.md
├── 02_Business_Requirements.md
├── 03_User_Personas.md
├── 04_User_Journeys.md
├── 05_Information_Architecture.md
├── 06_RBAC.md
│
├── Public/
├── Organizer/
├── Sponsor/
├── Partner/
├── Admin/
├── Backend/
├── UX/
├── Assets/
└── Roadmap/
```

---

# Product Modules

| Module ID | Module | Description |
|------------|---------|-------------|
| PUB | Public Website | Marketing & Marketplace |
| ORG | Organizer Workspace | Event & Sponsorship Management |
| SPO | Sponsor Workspace | Sponsor CRM |
| PAR | Partner Workspace | Agency Portal |
| ADM | Administration | Platform Management |
| API | Backend Services | APIs & Integrations |
| DB | Database | Schema & Storage |
| UX | Design System | UI/UX Standards |
| SEC | Security | Authentication & RBAC |
| AI | Artificial Intelligence | Recommendation & Matching |
| REP | Reporting | Analytics & Dashboards |

---

# User Roles

| Role ID | Role |
|-----------|----------------|
| R01 | Visitor |
| R02 | Organizer |
| R03 | Sponsor |
| R04 | Partner |
| R05 | Admin |
| R06 | Finance |
| R07 | Support |
| R08 | Super Admin |

---

# Feature ID Convention

Every feature follows this format:

```
MODULE-FEATURE-NUMBER
```

Example:

```
ORG-001
ORG-002
ORG-003

SPO-001

ADM-004

PUB-015
```

---

# Screen ID Convention

Each screen has a unique identifier.

```
SCR-PUB-001

SCR-ORG-001

SCR-SPO-001

SCR-ADM-001
```

---

# Component ID Convention

```
CMP-Button-001

CMP-Card-001

CMP-Modal-001

CMP-Table-001

CMP-Chart-001
```

---

# API Convention

```
API-AUTH-001

API-EVENT-001

API-SPONSOR-001

API-PAYMENT-001
```

---

# Database Convention

```
TB_USERS

TB_EVENTS

TB_SPONSORS

TB_DEALS

TB_MESSAGES
```

---

# Notification Convention

```
NOT-EMAIL

NOT-WHATSAPP

NOT-PUSH

NOT-SMS

NOT-INAPP
```

---

# Product Areas

## Public Platform

Feature Prefix

PUB

Includes

- Homepage
- Marketplace
- Categories
- Search
- Event Detail
- Pricing
- Authentication
- CMS
- Contact
- Blog

---

## Organizer

Feature Prefix

ORG

Includes

- Dashboard
- Events
- Event Builder
- Packages
- CRM
- Messages
- Meetings
- Calendar
- Team
- Contracts
- Analytics
- Reports
- Billing

---

## Sponsor

Prefix

SPO

Includes

- Dashboard
- Search
- Saved
- Applications
- Campaigns
- Contracts
- Reports
- Budget
- ROI

---

## Partner

Prefix

PAR

Includes

- Dashboard
- Clients
- Leads
- Deals
- Commission
- Reports

---

## Admin

Prefix

ADM

Includes

- Dashboard
- User Management
- Event Approval
- CMS
- Categories
- Industries
- Finance
- Reports
- Audit
- Roles

---

## Backend

Prefix

API

Includes

- Authentication
- User
- Event
- Search
- Recommendation
- Payments
- Notifications
- Analytics

---

# Development Phases

## Phase 1

Foundation

- Vision
- Requirements
- Personas
- User Journey

---

## Phase 2

Marketplace

- Homepage
- Search
- Listings

---

## Phase 3

Organizer Workspace

---

## Phase 4

Sponsor Workspace

---

## Phase 5

Partner Workspace

---

## Phase 6

Administration

---

## Phase 7

Backend

---

## Phase 8

UX

---

## Phase 9

Launch

---

# Documentation Template

Every feature document follows:

1. Overview
2. Business Goal
3. User Stories
4. Functional Requirements
5. Navigation
6. UI Layout
7. Components
8. Forms
9. Validation
10. Business Rules
11. Workflow
12. API
13. Database
14. Notifications
15. RBAC
16. Analytics
17. Acceptance Criteria

---

# Traceability Matrix

| Requirement | Feature | API | Database | Screen | Test Case |
|------------|----------|-----|-----------|---------|-----------|
| BR-001 | ORG-001 | API-EVENT-001 | TB_EVENTS | SCR-ORG-001 | TC-001 |
| BR-002 | SPO-002 | API-SPONSOR-001 | TB_SPONSORS | SCR-SPO-002 | TC-002 |
| BR-003 | ADM-001 | API-ADMIN-001 | TB_USERS | SCR-ADM-001 | TC-003 |

---

# Naming Standards

## Documents

```
01_Product_Vision.md

02_Business_Requirements.md

03_User_Personas.md
```

---

## APIs

```
POST /api/v1/events

GET /api/v1/events

PATCH /api/v1/events/{id}

DELETE /api/v1/events/{id}
```

---

## Database

Snake case

```
event_id

created_at

updated_at

organization_id
```

---

## Frontend

PascalCase

```
DashboardCard.tsx

SponsorCard.tsx

EventWizard.tsx
```

---

# Documentation Status

| Document | Status |
|-----------|---------|
| README | ✅ Complete |
| Master Index | ✅ Complete |
| Product Vision | ⏳ Pending |
| Business Requirements | ⏳ Pending |
| Personas | ⏳ Pending |
| User Journey | ⏳ Pending |
| Information Architecture | ⏳ Pending |
| RBAC | ⏳ Pending |

---

# Change Log

| Version | Date | Changes |
|----------|------|----------|
| 1.0.0 | July 2026 | Initial repository structure and indexing established |

---

# Next Document

**01_Product_Vision.md**

This document will define:

- Product Vision
- Market Opportunity
- Problem Statement
- Competitive Landscape
- Value Proposition
- Business Goals
- Success Metrics
- Product Principles
- Scope (In / Out)
- Release Strategy
- Long-term Roadmap
