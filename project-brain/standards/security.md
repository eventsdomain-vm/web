# Standards — Security

## Checklist
- SQL Injection ❌ → Use Eloquent, parameter binding, never raw queries
- XSS ❌ → Use Blade `{{ }}` escaping, never `{!! !!}` without verification
- CSRF ❌ → Use `@csrf` on all forms, `csrf_token()` on AJAX
- Authentication ❌ → Use Laravel's built-in auth, never custom auth logic
- Authorization ❌ → Use Spatie Permission gates, Policies, Form Request authorize()
- Secret Exposure ❌ → .env only, never commit secrets, use `config/` files
- Validation ❌ → Always use Form Requests or Validator facade
- File Upload ❌ → Validate mime types, size limits, store outside public
- Mass Assignment ❌ → Use `$fillable`, never `$guarded` alone
- Rate Limiting ✅ → Apply on API routes, auth attempts, form submissions
- HTTPS ✅ → Force in production

## Specific Rules
- All user input passes through Form Request validation before reaching Service
- File uploads: validate extension + mime + size, store in `storage/app/`, serve via Storage facade
- API endpoints: rate limit 60/min for auth, 30/min for guests
- Passwords: bcrypt hashed (Laravel default), min 8 chars
- Email verification required for all accounts before platform access
- Admin routes: additional IP whitelist (configurable)
- Session: HTTP-only, secure, SameSite=Lax
