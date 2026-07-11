# Security Review Checklist

## Authentication
- [ ] All protected routes have `auth` middleware
- [ ] Email verification required for platform access
- [ ] Passwords hashed (bcrypt)
- [ ] Rate limiting on login attempts
- [ ] Session security (HTTP-only, SameSite)

## Authorization
- [ ] Spatie Permission enforced at routes/middleware
- [ ] Policies cover all CRUD operations
- [ ] No authorization bypass in controllers
- [ ] Admin routes have additional protection

## Input Validation
- [ ] All inputs validated via Form Requests
- [ ] File uploads validated (type, size, mime)
- [ ] HTML escaped via Blade `{{ }}`
- [ ] No raw user input in SQL queries

## XSS Prevention
- [ ] `{{ }}` used in Blade — never `{!! !!}` without verification
- [ ] User-generated content sanitized
- [ ] CSP headers configured

## CSRF
- [ ] `@csrf` on all forms
- [ ] Axios/JS requests include CSRF token

## Data Protection
- [ ] Sensitive data never logged
- [ ] API keys in `.env` only
- [ ] Files stored outside public directory
- [ ] Database passwords not hardcoded
- [ ] `.env` in `.gitignore`
