# Memory — Routing

> **Note**: Route summary table has been added to `project.md` Section 15 (Development Standards → Route Map Reference). This file remains the authoritative detailed route map.

## Web Routes (web.php)

### Public Routes (guest.blade.php layout)
```
GET  /                        → PublicController@home
GET  /events                  → EventController@index (public listing)
GET  /events/{slug}           → EventController@show (public detail)
GET  /categories              → CategoryController@index
GET  /roi-calculator          → RoiCalculatorController@index
GET  /pricing                 → PageController@pricing
GET  /blog                    → BlogController@index
GET  /blog/{slug}             → BlogController@show
GET  /contact                 → PageController@contact
POST /contact                 → PageController@sendContact
GET  /about                   → PageController@about
GET  /faq                     → PageController@faq
GET  /privacy                 → PageController@privacy
GET  /terms                   → PageController@terms
```

### Auth Routes (guest layout, no auth middleware)
```
GET  /login                   → Auth\LoginController@create
POST /login                   → Auth\LoginController@store
GET  /register                → Auth\RegisterController@create
POST /register                → Auth\RegisterController@store
POST /logout                  → Auth\LoginController@destroy
GET  /forgot-password         → Auth\PasswordResetController@create
POST /forgot-password         → Auth\PasswordResetController@send
GET  /reset-password/{token}  → Auth\PasswordResetController@edit
POST /reset-password          → Auth\PasswordResetController@update
GET  /email/verify            → Auth\VerificationController@notice
GET  /email/verify/{id}/{hash}→ Auth\VerificationController@verify
POST /email/verification-notification → Auth\VerificationController@resend
```

### Organizer Routes (middleware: auth, role:organizer, layout: organizer.blade.php)
```
GET     /organizer/dashboard              → OrganizerDashboardController@index
GET     /organizer/events                 → OrganizerEventController@index
GET     /organizer/events/create          → OrganizerEventController@create
POST    /organizer/events                 → OrganizerEventController@store
GET     /organizer/events/{id}            → OrganizerEventController@show
GET     /organizer/events/{id}/edit       → OrganizerEventController@edit
PUT     /organizer/events/{id}            → OrganizerEventController@update
DELETE  /organizer/events/{id}            → OrganizerEventController@destroy
POST    /organizer/events/{id}/publish    → OrganizerEventController@publish
POST    /organizer/events/{id}/archive    → OrganizerEventController@archive
GET     /organizer/events/{id}/packages   → OrganizerPackageController@index
POST    /organizer/events/{id}/packages   → OrganizerPackageController@store
PUT     /organizer/events/{id}/packages/{pkg} → OrganizerPackageController@update
DELETE  /organizer/events/{id}/packages/{pkg} → OrganizerPackageController@destroy
GET     /organizer/events/{id}/sponsors   → OrganizerSponsorController@index
POST    /organizer/events/{id}/sponsors/{req} → OrganizerSponsorController@respond
GET     /organizer/events/{id}/partners   → OrganizerPartnerController@index
POST    /organizer/events/{id}/partners   → OrganizerPartnerController@request
GET     /organizer/events/{id}/schedule   → OrganizerScheduleController@index
POST    /organizer/events/{id}/schedule   → OrganizerScheduleController@store
DELETE  /organizer/events/{id}/schedule/{sched} → OrganizerScheduleController@destroy
GET     /organizer/events/{id}/gallery    → OrganizerGalleryController@index
POST    /organizer/events/{id}/gallery    → OrganizerGalleryController@store
DELETE  /organizer/events/{id}/gallery/{img} → OrganizerGalleryController@destroy
GET     /organizer/events/{id}/analytics  → OrganizerAnalyticsController@show
GET     /organizer/messages               → OrganizerMessageController@index
GET     /organizer/messages/{id}          → OrganizerMessageController@show
POST    /organizer/messages/{id}          → OrganizerMessageController@send
GET     /organizer/notifications          → OrganizerNotificationController@index
POST    /organizer/notifications/{id}/read → OrganizerNotificationController@markRead
GET     /organizer/team                   → OrganizerTeamController@index
POST    /organizer/team                   → OrganizerTeamController@invite
DELETE  /organizer/team/{id}              → OrganizerTeamController@remove
GET     /organizer/profile                → OrganizerProfileController@edit
PUT     /organizer/profile                → OrganizerProfileController@update
GET     /organizer/settings               → OrganizerSettingsController@edit
PUT     /organizer/settings               → OrganizerSettingsController@update
```

### Sponsor Routes (middleware: auth, role:sponsor, layout: sponsor.blade.php)
```
GET     /sponsor/dashboard                → SponsorDashboardController@index
GET     /sponsor/discover                 → SponsorDiscoverController@index
GET     /sponsor/discover/{event}         → SponsorDiscoverController@show
POST    /sponsor/discover/{event}/enquiry → SponsorDiscoverController@sendEnquiry
GET     /sponsor/saved                    → SponsorSavedController@index
POST    /sponsor/saved/{event}            → SponsorSavedController@toggle
GET     /sponsor/enquiries                → SponsorEnquiryController@index
GET     /sponsor/enquiries/{id}           → SponsorEnquiryController@show
GET     /sponsor/sponsored                → SponsorSponsoredController@index
GET     /sponsor/messages                 → SponsorMessageController@index
GET     /sponsor/messages/{id}            → SponsorMessageController@show
POST    /sponsor/messages/{id}            → SponsorMessageController@send
GET     /sponsor/notifications            → SponsorNotificationController@index
GET     /sponsor/profile                  → SponsorProfileController@edit
PUT     /sponsor/profile                  → SponsorProfileController@update
GET     /sponsor/settings                 → SponsorSettingsController@edit
PUT     /sponsor/settings                 → SponsorSettingsController@update
```

### Partner Routes (middleware: auth, role:partner, layout: partner.blade.php)
```
GET     /partner/dashboard                → PartnerDashboardController@index
GET     /partner/services                 → PartnerServiceController@index
GET     /partner/services/create          → PartnerServiceController@create
POST    /partner/services                 → PartnerServiceController@store
GET     /partner/services/{id}/edit       → PartnerServiceController@edit
PUT     /partner/services/{id}            → PartnerServiceController@update
DELETE  /partner/services/{id}            → PartnerServiceController@destroy
GET     /partner/opportunities            → PartnerOpportunityController@index
POST    /partner/opportunities/{id}/bid   → PartnerOpportunityController@bid
GET     /partner/contracts                → PartnerContractController@index
GET     /partner/availability             → PartnerAvailabilityController@edit
PUT     /partner/availability             → PartnerAvailabilityController@update
GET     /partner/portfolio                → PartnerPortfolioController@index
POST    /partner/portfolio                → PartnerPortfolioController@store
DELETE  /partner/portfolio/{id}           → PartnerPortfolioController@destroy
GET     /partner/reviews                  → PartnerReviewController@index
GET     /partner/messages                 → PartnerMessageController@index
GET     /partner/messages/{id}            → PartnerMessageController@show
POST    /partner/messages/{id}            → PartnerMessageController@send
GET     /partner/notifications            → PartnerNotificationController@index
GET     /partner/profile                  → PartnerProfileController@edit
PUT     /partner/profile                  → PartnerProfileController@update
GET     /partner/settings                 → PartnerSettingsController@edit
PUT     /partner/settings                 → PartnerSettingsController@update
```

### Admin Routes (middleware: auth, role:admin, layout: admin.blade.php)
```
GET     /admin/dashboard                  → AdminDashboardController@index
GET     /admin/events                     → AdminEventController@index
GET     /admin/events/pending             → AdminEventController@pending
GET     /admin/events/{id}                → AdminEventController@show
POST    /admin/events/{id}/approve        → AdminEventController@approve
POST    /admin/events/{id}/reject         → AdminEventController@reject
GET     /admin/users                      → AdminUserController@index
GET     /admin/users/{id}                 → AdminUserController@show
POST    /admin/users/{id}/verify          → AdminUserController@verify
POST    /admin/users/{id}/ban             → AdminUserController@ban
GET     /admin/categories                 → AdminCategoryController@index
POST    /admin/categories                 → AdminCategoryController@store
PUT     /admin/categories/{id}            → AdminCategoryController@update
DELETE  /admin/categories/{id}            → AdminCategoryController@destroy
GET     /admin/sponsorships               → AdminSponsorshipController@index
GET     /admin/partners                   → AdminPartnerController@index
POST    /admin/partners/{id}/verify       → AdminPartnerController@verify
GET     /admin/reports                    → AdminReportController@index
GET     /admin/reports/{type}             → AdminReportController@show
GET     /admin/cms                        → AdminCmsController@index
POST    /admin/cms                        → AdminCmsController@store
PUT     /admin/cms/{id}                   → AdminCmsController@update
DELETE  /admin/cms/{id}                   → AdminCmsController@destroy
GET     /admin/roles                      → AdminRoleController@index
POST    /admin/roles                      → AdminRoleController@store
PUT     /admin/roles/{id}                 → AdminRoleController@update
GET     /admin/settings                   → AdminSettingController@edit
PUT     /admin/settings                   → AdminSettingController@update
GET     /admin/logs                       → AdminLogController@index
```

## API Routes (api.php)
```
POST    /api/messages/send                → MessageController@send
GET     /api/messages/{id}                → MessageController@fetch
POST    /api/messages/typing              → MessageController@typing
POST    /api/upload                       → UploadController@store
POST    /api/enquiry/send                 → EnquiryController@send
GET     /api/search/events                → SearchController@events
GET     /api/filters/categories           → FilterController@categories
GET     /api/filters/cities               → FilterController@cities
POST    /api/roi/calculate                → RoiController@calculate
```
