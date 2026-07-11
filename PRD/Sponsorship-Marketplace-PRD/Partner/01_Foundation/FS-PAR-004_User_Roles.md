# FS-PAR-004 User Roles

**Module ID:** FS-PAR-004

**Document Name:** User Roles

**Version:** 1.0

**Status:** Draft

**Owner:** Product Team

---

# Table of Contents

1. Introduction
2. Purpose
3. Role Hierarchy
4. User Role Framework
5. Standard Roles
6. Role Responsibilities
7. Permission Levels
8. Approval Authority
9. Delegation Rules
10. Team Structure
11. Role Assignment
12. Access Scope
13. Separation of Duties
14. Role Lifecycle
15. Business Rules
16. Future Extensibility

---

# 1. Introduction

The Partner Workspace supports Role-Based Access Control (RBAC) to ensure users only access the information and functionality required for their responsibilities.

A Partner Organization may contain multiple users with different responsibilities while sharing the same workspace.

Roles determine:

- Workspace visibility
- Feature availability
- Approval authority
- Financial access
- Administrative privileges
- Team management permissions
- Reporting access
- Data ownership

Roles are independent of Partner Type.

Example:

A Sponsorship Agency and a Sales Partner organization can both have:

- Owner
- Manager
- Sales Executive
- Account Manager

The Partner Type defines **business capabilities**, while User Roles define **operational permissions**.

---

# 2. Purpose

This document defines:

- User hierarchy
- Role definitions
- Responsibilities
- Approval levels
- Data access
- Security boundaries
- Administrative authority

---

# 3. Role Hierarchy

```
Partner Organization

        │

        ▼

Partner Owner
        │
        ├───────────────┐
        ▼               ▼
Partner Manager    Finance Manager
        │               │
        ├───────┐       │
        ▼       ▼       ▼
Sales     Account   Finance Executive
Executive  Manager
        │
        ▼
Coordinator
        │
        ▼
Analyst
        │
        ▼
Read Only User
```

The hierarchy controls both reporting relationships and approval authority.

---

# 4. User Role Framework

Every user belongs to:

```
Partner Organization
        │
        ▼
Department
        │
        ▼
Role
        │
        ▼
Permission Set
```

Example

```
Agency ABC

↓

Sales Department

↓

Sales Executive

↓

Sales Permission Set
```

---

# 5. Standard Roles

The platform includes the following default roles.

## 5.1 Partner Owner

Highest authority within a Partner Organization.

### Responsibilities

- Workspace administration
- Team management
- Financial approvals
- Commission oversight
- Client ownership
- Business settings
- Security policies

### Permissions

- Full access
- User management
- Role assignment
- Workspace settings
- Reports
- Financial dashboards
- Integrations

Cannot be restricted by managers.

---

## 5.2 Partner Manager

Responsible for operational management.

### Responsibilities

- Team supervision
- Lead allocation
- Deal approvals
- Client assignments
- Performance monitoring
- Escalation handling

### Permissions

- Manage team
- Assign opportunities
- Approve proposals
- Monitor pipelines
- Access reports

Cannot modify organization ownership.

---

## 5.3 Sales Executive

Primary business development role.

### Responsibilities

- Prospect clients
- Discover opportunities
- Qualify leads
- Submit proposals
- Update pipelines
- Schedule meetings

### Permissions

- Create leads
- Update opportunities
- Manage own deals
- Access assigned clients

Cannot approve financial transactions.

---

## 5.4 Account Manager

Responsible for relationship management.

### Responsibilities

- Client communication
- Campaign coordination
- Renewals
- Satisfaction reviews
- Meeting management

### Permissions

- View client history
- Schedule meetings
- Manage campaigns
- Upload documents

Cannot change commissions.

---

## 5.5 Finance Manager

Financial authority.

### Responsibilities

- Invoice approvals
- Commission approvals
- Payment reconciliation
- Revenue reports

### Permissions

- Financial dashboard
- Commission approval
- Payment management
- Export financial reports

Cannot modify operational data.

---

## 5.6 Finance Executive

Supports finance operations.

### Responsibilities

- Generate invoices
- Process payments
- Verify transactions

Cannot approve payments.

Approval required from Finance Manager.

---

## 5.7 Operations Coordinator

Coordinates internal operations.

### Responsibilities

- Task management
- Meeting scheduling
- Document management
- Workflow tracking

---

## 5.8 Business Analyst

Responsible for reporting.

### Responsibilities

- Reports
- Analytics
- KPI monitoring
- Forecasting

Read-only operational access.

---

## 5.9 Read Only User

View-only access.

Used for:

- Auditors
- Executives
- External consultants

No editing permissions.

---

# 6. Role Responsibilities Matrix

| Responsibility | Owner | Manager | Sales | Account | Finance | Analyst |
|---------------|-------|---------|-------|----------|----------|----------|
| Manage Users | ✓ | Limited | ✗ | ✗ | ✗ | ✗ |
| Manage Clients | ✓ | ✓ | Own | Own | View | View |
| Create Leads | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| Manage Deals | ✓ | ✓ | Own | View | View | View |
| Approve Deals | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Campaign Coordination | ✓ | ✓ | Limited | ✓ | ✗ | View |
| Commission Approval | ✓ | ✗ | ✗ | ✗ | ✓ | ✗ |
| Reports | ✓ | ✓ | Own | Own | Finance | ✓ |
| Workspace Settings | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |

---

# 7. Permission Levels

The platform supports multiple permission levels.

```
No Access

↓

View

↓

Create

↓

Edit

↓

Delete

↓

Approve

↓

Manage

↓

Admin
```

Permissions are cumulative.

---

# 8. Approval Authority

## Deal Approval

Sales Executive

↓

Partner Manager

↓

Partner Owner

---

## Commission Approval

Finance Executive

↓

Finance Manager

↓

Partner Owner

---

## User Approval

Manager

↓

Owner

---

## High Value Deals

Manager

↓

Owner

↓

Platform Admin (Optional)

---

# 9. Delegation Rules

Users may delegate responsibilities temporarily.

Supported delegation includes:

- Meetings
- Client ownership
- Task assignment
- Deal ownership
- Approval authority (configurable)

Delegation history must be audited.

---

# 10. Team Structure

```
Partner Organization

Sales Team

Account Management

Finance

Operations

Analytics

Administration
```

Departments are configurable.

---

# 11. Role Assignment

Users receive:

```
Partner Organization

↓

Department

↓

Role

↓

Permission Set

↓

Feature Access
```

Roles may be changed by authorized users.

---

# 12. Access Scope

Users can access:

## Own Records

Only assigned records.

---

## Team Records

Visible to managers.

---

## Department Records

Optional.

---

## Organization Records

Owner only.

---

## Global Records

Platform administrators only.

---

# 13. Separation of Duties

The platform prevents conflicts of interest.

Examples:

- Creator cannot approve own commission.
- Sales Executive cannot approve payments.
- Finance Executive cannot approve own invoices.
- Read-only users cannot modify records.
- Analysts cannot approve business actions.

---

# 14. Role Lifecycle

```
User Invited

↓

Invitation Accepted

↓

Role Assigned

↓

Workspace Access

↓

Active User

↓

Role Updated

↓

Suspended

↓

Reactivated

↓

Archived
```

Every role change is audited.

---

# 15. Business Rules

- Every user belongs to exactly one Partner Organization.
- Every user must have one primary role.
- Additional permission sets may extend access.
- Financial approvals require authorized roles.
- Deleted users remain in audit history.
- Owners cannot be deleted while active assets exist.
- Managers inherit visibility over subordinate users.
- Sensitive actions require audit logging.

---

# 16. Future Extensibility

The RBAC framework supports:

- Custom Roles
- Custom Permission Sets
- Department-based Security
- Territory-based Access
- Industry-based Visibility
- Temporary Roles
- External Contractors
- Multi-Organization Membership
- Dynamic Permissions
- API Permission Profiles

The permission engine is metadata-driven, allowing administrators to create new roles and permission sets without requiring application code changes.

---

# Related Documents

- FS-PAR-001_Partner_Workspace.md
- FS-PAR-002_Partner_Business_Model.md
- FS-PAR-003_Partner_Types.md
- FS-PAR-005_Workspace_Architecture.md
- Permission_Matrix.md
- Authorization.md
- Team_Management.md