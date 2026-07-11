# FS-PAR-003 Partner Types

**Module ID:** FS-PAR-003

**Document Name:** Partner Types

**Version:** 1.0

**Status:** Draft

**Owner:** Product Team

---

# Table of Contents

1. Introduction
2. Purpose
3. Partner Framework
4. Partner Classification
5. Partner Type Comparison
6. Sponsorship Agency
7. Sales Partner
8. Business Consultant
9. Affiliate Partner
10. Reseller Partner
11. Strategic Partner
12. Corporate Partnership Team
13. Regional Partner
14. Partner Organization Structure
15. Ownership Models
16. Commission Models
17. Permission Model
18. Business Rules
19. Partner Lifecycle
20. Future Expansion

---

# 1. Introduction

The Event Sponsorship Marketplace supports multiple categories of Partners.

Instead of building different workspaces for different partner businesses, the platform provides one unified Partner Workspace where functionality is enabled through Partner Types.

Each Partner Type defines:

- Business Role
- Responsibilities
- Revenue Model
- Permissions
- Client Ownership
- Deal Ownership
- Commission Structure
- Operational Workflow

---

# 2. Purpose

This document defines:

- Supported Partner Types
- Organizational structures
- Business responsibilities
- Permission differences
- Revenue models
- Workspace behavior

---

# 3. Partner Framework

```
Partner Organization
        │
        ├── Partner Type
        │
        ├── Business Model
        │
        ├── Commission Plan
        │
        ├── Team Members
        │
        ├── Assigned Clients
        │
        ├── Opportunities
        │
        ├── Deals
        │
        └── Reports
```

Every Partner Organization operates inside a single Partner Workspace.

Partner Type determines available features.

---

# 4. Partner Classification

The platform supports the following Partner Types.

```
Partner
│
├── Sponsorship Agency
├── Sales Partner
├── Business Consultant
├── Affiliate Partner
├── Reseller
├── Strategic Partner
├── Corporate Partnership Team
└── Regional Partner
```

Additional Partner Types can be configured without changing application logic.

---

# 5. Partner Type Comparison

| Partner Type | Own Clients | Generate Leads | Negotiate Deals | Manage Campaigns | Earn Commission | Team Management |
|--------------|-------------|----------------|-----------------|------------------|-----------------|-----------------|
| Sponsorship Agency | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Sales Partner | ✅ | ✅ | ✅ | Limited | ✅ | Limited |
| Business Consultant | ✅ | Advisory | Advisory | Limited | Optional | Limited |
| Affiliate Partner | Referral Only | Referral | No | No | Referral Fee | No |
| Reseller | ✅ | ✅ | ✅ | Optional | ✅ | Optional |
| Strategic Partner | Shared | Shared | Shared | Shared | Custom | Yes |
| Corporate Partnership Team | Internal | Internal | Internal | Internal | No | Yes |
| Regional Partner | Regional | Regional | Regional | Regional | Regional | Yes |

---

# 6. Sponsorship Agency

## Description

A Sponsorship Agency manages multiple sponsor and organizer accounts and delivers end-to-end sponsorship consulting.

### Responsibilities

- Acquire clients
- Search marketplace
- Recommend opportunities
- Prepare proposals
- Negotiate deals
- Coordinate campaigns
- Track ROI
- Manage renewals

### Revenue

- Commission
- Retainer
- Consulting Fee
- Campaign Management Fee

### Workspace Access

- Full Partner Workspace
- Team Management
- Reports
- Commission
- Documents
- Integrations

---

# 7. Sales Partner

## Description

Sales Partners focus primarily on acquiring sponsorship deals.

### Responsibilities

- Prospect new clients
- Qualify leads
- Recommend opportunities
- Submit proposals
- Close deals

### Revenue

- Deal Commission
- Sales Bonus
- Incentive Programs

### Workspace Access

- Dashboard
- Clients
- Leads
- Deals
- Meetings
- Reports

No financial administration access.

---

# 8. Business Consultant

## Description

Consultants provide advisory services rather than direct sales.

### Responsibilities

- Sponsorship strategy
- Brand alignment
- Event evaluation
- ROI recommendations
- Market research

### Revenue

- Consulting Fee
- Retainer
- Advisory Agreement

### Workspace Access

- Clients
- Reports
- Marketplace
- Documents
- Analytics

No commission approval permissions.

---

# 9. Affiliate Partner

## Description

Affiliate Partners generate referrals without managing deals.

### Responsibilities

- Refer sponsors
- Refer organizers
- Share opportunities
- Promote marketplace

### Revenue

- Referral Commission
- Referral Bonus

### Workspace Access

- Dashboard
- Referrals
- Earnings
- Marketplace

Cannot access deal management.

---

# 10. Reseller Partner

## Description

Resellers package sponsorship services with their own offerings.

### Responsibilities

- Sell sponsorship packages
- Manage client portfolio
- Coordinate agreements
- Handle renewals

### Revenue

- Margin
- Commission
- Package Fee

Workspace is similar to Sponsorship Agency with configurable permissions.

---

# 11. Strategic Partner

## Description

Strategic Partners collaborate directly with the platform to expand market reach.

Examples

- Industry Associations
- Media Groups
- Government Organizations
- Large Agencies

### Revenue

Custom contractual agreements.

### Features

- Shared Opportunities
- Shared Clients
- Enterprise Reports
- White-label Features

---

# 12. Corporate Partnership Team

## Description

Internal business development teams representing a corporate sponsor.

### Responsibilities

- Internal sponsorship planning
- Event evaluation
- Campaign coordination

Revenue is not commission-based.

---

# 13. Regional Partner

## Description

Partners responsible for specific geographic territories.

Example

```
India

├── North

├── South

├── East

├── West
```

Responsibilities include:

- Regional acquisition
- Territory management
- Regional reports

---

# 14. Partner Organization Structure

```
Partner Organization

        │

        ├── Owner

        ├── Managers

        ├── Sales Team

        ├── Account Managers

        ├── Finance

        ├── Operations

        └── Analysts
```

Large organizations may contain multiple teams.

---

# 15. Ownership Models

## Single Ownership

One Partner owns one client.

---

## Shared Ownership

Multiple Partners collaborate.

---

## Territory Ownership

Ownership restricted by geography.

---

## Vertical Ownership

Ownership restricted by industry.

---

## Enterprise Ownership

Multiple business units collaborate.

---

# 16. Commission Models

Supported commission structures:

## Percentage

Based on deal value.

---

## Fixed

Flat amount.

---

## Tiered

Different percentages based on volume.

---

## Milestone-Based

Paid after deliverables.

---

## Recurring

Recurring annual commissions.

---

## Hybrid

Combination of multiple structures.

---

# 17. Permission Model

Permissions depend on Partner Type.

Examples:

| Module | Agency | Sales | Consultant | Affiliate |
|---------|--------|-------|------------|------------|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Clients | ✅ | ✅ | View | View |
| Leads | ✅ | ✅ | View | No |
| Deals | ✅ | ✅ | View | No |
| Campaigns | ✅ | Limited | View | No |
| Reports | ✅ | Limited | ✅ | Limited |
| Commission | ✅ | Own | No | Referral |
| Settings | ✅ | Limited | Limited | No |

---

# 18. Business Rules

- Every Partner belongs to exactly one Partner Type.
- Partner Type determines workspace capabilities.
- Permissions are inherited from Partner Type.
- Commission plans are linked to Partner Type.
- Approval workflows may differ by Partner Type.
- Custom Partner Types can be configured by Platform Admin.

---

# 19. Partner Lifecycle

```
Partner Registration
        │
        ▼
Partner Type Selection
        │
        ▼
Verification
        │
        ▼
Approval
        │
        ▼
Workspace Provisioning
        │
        ▼
Client Assignment
        │
        ▼
Business Operations
        │
        ▼
Performance Monitoring
        │
        ▼
Renewal / Upgrade / Deactivation
```

---

# 20. Future Expansion

The Partner Framework is designed to support future business models without application redesign.

Possible future Partner Types include:

- Technology Partner
- AI Service Partner
- Media Partner
- Hospitality Partner
- Ticketing Partner
- Venue Partner
- Payment Partner
- Marketing Agency
- Influencer Network
- International Representative

The Partner Type engine is metadata-driven, allowing new types, permissions, commission structures, and workflows to be configured through the Admin Workspace without requiring code changes.

---

# Related Documents

- FS-PAR-001_Partner_Workspace.md
- FS-PAR-002_Partner_Business_Model.md
- FS-PAR-004_User_Roles.md
- Permission_Matrix.md
- Commission.md
- Team_Management.md
- Authorization.md