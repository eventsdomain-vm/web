<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCmsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\AdminPartnerController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminRedirectController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminRobotsController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminSchemaController;
use App\Http\Controllers\Admin\AdminSeoAuditController;
use App\Http\Controllers\Admin\AdminSeoDashboardController;
use App\Http\Controllers\Admin\AdminSeoSettingsController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSitemapController;
use App\Http\Controllers\Admin\AdminSponsorshipController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AdminEventDateController;
use App\Http\Controllers\AdminEventScheduleController;
use App\Http\Controllers\AdminEventTeamController;
use App\Http\Controllers\AdminEventVenueController;
use App\Http\Controllers\AdminSponsorshipPackageController;
use App\Http\Controllers\Admin\AdminOrganizerContractController;
use App\Http\Controllers\Admin\AdminOrganizerController;
use App\Http\Controllers\Admin\AdminOrganizerEventGalleryController;
use App\Http\Controllers\Admin\AdminOrganizerEventScheduleController;
use App\Http\Controllers\Admin\AdminOrganizerEventTeamController;
use App\Http\Controllers\Admin\AdminOrganizerPostEventController;
use App\Http\Controllers\Admin\AdminOrganizerRenewalController;
use App\Http\Controllers\Admin\AdminOrganizerSocialController;
use App\Http\Controllers\Admin\AdminOrganizerSRMController;
use App\Http\Controllers\Admin\AdminPartnerBidController;
use App\Http\Controllers\Admin\AdminPartnerCampaignController;
use App\Http\Controllers\Admin\AdminPartnerClientController;
use App\Http\Controllers\Admin\AdminPartnerCommissionController;
use App\Http\Controllers\Admin\AdminPartnerDealController;
use App\Http\Controllers\Admin\AdminPartnerLeadController;
use App\Http\Controllers\Admin\AdminPartnerMeetingController;
use App\Http\Controllers\Admin\AdminPartnerServiceController;
use App\Http\Controllers\Admin\AdminPartnerTaskController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Organizer\ContractController as OrganizerContractController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\EventGalleryController as OrganizerGalleryController;
use App\Http\Controllers\Organizer\EventScheduleController as OrganizerScheduleController;
use App\Http\Controllers\Organizer\EventTeamController as OrganizerTeamController;
use App\Http\Controllers\Organizer\PartnerController as OrganizerPartnerController;
use App\Http\Controllers\Organizer\PostEventController as OrganizerPostEventController;
use App\Http\Controllers\Organizer\ProfileController as OrganizerProfileController;
use App\Http\Controllers\Organizer\RenewalController as OrganizerRenewalController;
use App\Http\Controllers\Organizer\ReportController as OrganizerReportController;
use App\Http\Controllers\Organizer\SocialAccountController;
use App\Http\Controllers\Organizer\SocialPostController;
use App\Http\Controllers\Organizer\SponsorAcquisitionController as OrganizerAcquisitionController;
use App\Http\Controllers\Organizer\SponsorController as OrganizerSponsorController;
use App\Http\Controllers\Organizer\SponsorshipPackageController as OrganizerPackageController;
use App\Http\Controllers\Organizer\SRMController as OrganizerSRMController;
use App\Http\Controllers\Partner\AICopilotController;
use App\Http\Controllers\Partner\BidController as PartnerBidController;
use App\Http\Controllers\Partner\CampaignController;
use App\Http\Controllers\Partner\ClientController;
use App\Http\Controllers\Partner\CommissionController;
use App\Http\Controllers\Partner\DealController;
use App\Http\Controllers\Partner\LeadController;
use App\Http\Controllers\Partner\MeetingController;
use App\Http\Controllers\Partner\NotificationController;
use App\Http\Controllers\Partner\ReportController;
use App\Http\Controllers\Partner\ServiceController as PartnerServiceController;
use App\Http\Controllers\Partner\SettingsController;
use App\Http\Controllers\Partner\TaskController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sponsor\AIMatchingController as SponsorAIMatchingController;
use App\Http\Controllers\Sponsor\AnalyticsController as SponsorAnalyticsController;
use App\Http\Controllers\Sponsor\AnnouncementController as SponsorAnnouncementController;
use App\Http\Controllers\Sponsor\AuditLogController as SponsorAuditLogController;
use App\Http\Controllers\Sponsor\BrandAssetController as SponsorBrandAssetController;
use App\Http\Controllers\Sponsor\BudgetController as SponsorBudgetController;
use App\Http\Controllers\Sponsor\CampaignController as SponsorCampaignController;
use App\Http\Controllers\Sponsor\CompareController as SponsorCompareController;
use App\Http\Controllers\Sponsor\ContractController as SponsorContractController;
use App\Http\Controllers\Sponsor\DashboardController as SponsorDashboardController;
use App\Http\Controllers\Sponsor\DocumentController as SponsorDocumentController;
use App\Http\Controllers\Sponsor\EventController as SponsorEventController;
use App\Http\Controllers\Sponsor\IntegrationController as SponsorIntegrationController;
use App\Http\Controllers\Sponsor\InvoiceController as SponsorInvoiceController;
use App\Http\Controllers\Sponsor\MessageCenterController as SponsorMessageCenterController;
use App\Http\Controllers\Sponsor\NegotiationController as SponsorNegotiationController;
use App\Http\Controllers\Sponsor\NotificationController as SponsorNotificationController;
use App\Http\Controllers\Sponsor\PipelineController as SponsorPipelineController;
use App\Http\Controllers\Sponsor\ProposalController as SponsorProposalController;
use App\Http\Controllers\Sponsor\ReportController as SponsorReportController;
use App\Http\Controllers\Sponsor\RequestController as SponsorRequestController;
use App\Http\Controllers\Sponsor\SavedEventController as SponsorSavedEventController;
use App\Http\Controllers\Sponsor\SecuritySettingsController as SponsorSecuritySettingsController;
use App\Http\Controllers\Sponsor\SettingsController as SponsorSettingsController;
use App\Http\Controllers\Sponsor\TaskController as SponsorTaskController;
use App\Http\Controllers\Sponsor\TeamController as SponsorTeamController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [CmsPageController::class, 'show'])->name('about');
Route::get('/contact', [CmsPageController::class, 'show'])->name('contact');
Route::get('/faq', [CmsPageController::class, 'show'])->name('faq');
Route::get('/privacy', [CmsPageController::class, 'show'])->name('privacy');
Route::get('/terms', [CmsPageController::class, 'show'])->name('terms');
Route::get('/pricing', [CmsPageController::class, 'show'])->name('pricing');
Route::get('/refund', [CmsPageController::class, 'show'])->name('refund');

// Public Event Routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/past', [EventController::class, 'past'])->name('events.past');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Auth Routes
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/gst', [ProfileController::class, 'updateGst'])->name('profile.gst.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Messaging Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/create/{user}', [MessageController::class, 'create'])->name('messages.create');

    // Dashboard Pages
    Route::get('/analytics', AnalyticsController::class)->name('analytics');
    Route::get('/enquiries', fn () => view('enquiries'))->name('enquiries');
    Route::get('/settings', fn () => view('settings'))->name('settings');
});

// Organizer Routes
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerEventController::class, 'dashboard'])->name('dashboard');

    // Draft endpoints (must be before resource to avoid wildcard capture)
    Route::post('/events/save-draft', [OrganizerEventController::class, 'saveDraft'])->name('events.saveDraft');
    Route::get('/events/load-draft', [OrganizerEventController::class, 'loadDraft'])->name('events.loadDraft');
    Route::delete('/events/{id}/discard-draft', [OrganizerEventController::class, 'discardDraft'])->name('events.discardDraft');

    Route::resource('events', OrganizerEventController::class);

    Route::resource('events.schedules', OrganizerScheduleController::class);
    Route::resource('events.packages', OrganizerPackageController::class);
    Route::resource('events.team', OrganizerTeamController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('events.gallery', OrganizerGalleryController::class)->only(['index', 'store', 'destroy']);

    // Social Account Management
    Route::get('/social', [SocialAccountController::class, 'index'])->name('social.index');
    Route::get('/social/{provider}/connect', [SocialAccountController::class, 'connect'])->name('social.connect');
    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'callback'])->name('social.callback');
    Route::delete('/social/{provider}/disconnect', [SocialAccountController::class, 'disconnect'])->name('social.disconnect');
    Route::get('/social/status', [SocialAccountController::class, 'status'])->name('social.status');

    // Sponsorship Request Management
    Route::post('/events/{event}/requests/{request}/accept', [OrganizerSponsorController::class, 'acceptRequest'])->name('requests.accept');
    Route::post('/events/{event}/requests/{request}/reject', [OrganizerSponsorController::class, 'rejectRequest'])->name('requests.reject');

    // Partner Bid Management
    Route::post('/events/{event}/bids/{bid}/accept', [OrganizerPartnerController::class, 'acceptBid'])->name('bids.accept');
    Route::post('/events/{event}/bids/{bid}/reject', [OrganizerPartnerController::class, 'rejectBid'])->name('bids.reject');

    // Social Posts
    Route::get('/posts', [SocialPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [SocialPostController::class, 'show'])->name('posts.show');
    Route::post('/events/{event}/posts', [SocialPostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/publish', [SocialPostController::class, 'publish'])->name('posts.publish');
    Route::delete('/posts/{post}', [SocialPostController::class, 'destroy'])->name('posts.destroy');

    // --- PRD Workspace Modules ---

    // Profile & Settings
    Route::get('/profile', [OrganizerProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [OrganizerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/settings', [OrganizerProfileController::class, 'updateSettings'])->name('profile.update-settings');

    // Sponsor Relationship Management
    Route::get('/srm', [OrganizerSRMController::class, 'index'])->name('srm.index');
    Route::get('/srm/{id}', [OrganizerSRMController::class, 'show'])->name('srm.show');
    Route::post('/srm/{id}/health', [OrganizerSRMController::class, 'updateHealth'])->name('srm.update-health');

    // Renewal Pipeline
    Route::get('/renewals', [OrganizerRenewalController::class, 'index'])->name('renewals.index');
    Route::post('/renewals', [OrganizerRenewalController::class, 'store'])->name('renewals.store');
    Route::post('/renewals/{id}/stage', [OrganizerRenewalController::class, 'updateStage'])->name('renewals.update-stage');

    // Post-Event Intelligence
    Route::get('/post-event', [OrganizerPostEventController::class, 'index'])->name('post-event.index');
    Route::get('/post-event/create', [OrganizerPostEventController::class, 'create'])->name('post-event.create');
    Route::post('/post-event', [OrganizerPostEventController::class, 'store'])->name('post-event.store');
    Route::get('/post-event/{id}', [OrganizerPostEventController::class, 'show'])->name('post-event.show');

    // Analytics Reports
    Route::get('/reports', [OrganizerReportController::class, 'index'])->name('reports.index');

    // Contracts & Finance
    Route::get('/contracts', [OrganizerContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{id}', [OrganizerContractController::class, 'show'])->name('contracts.show');
    Route::post('/contracts/{id}/status', [OrganizerContractController::class, 'updateStatus'])->name('contracts.update-status');

    // Sponsor Acquisition Pipeline
    Route::get('/acquisition', [OrganizerAcquisitionController::class, 'index'])->name('acquisition.index');
    Route::post('/acquisition/invite/{event}', [OrganizerAcquisitionController::class, 'invite'])->name('acquisition.invite');
});

// Sponsor Routes
Route::middleware(['auth', 'role:sponsor'])->prefix('sponsor')->name('sponsor.')->group(function () {
    Route::get('/dashboard', [SponsorDashboardController::class, 'index'])->name('dashboard');

    // Event Discovery
    Route::get('/events', [SponsorEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [SponsorEventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/request', [SponsorEventController::class, 'requestSponsorship'])->name('events.request');

    // Save / Unsave Events
    Route::get('/saved', [SponsorSavedEventController::class, 'index'])->name('saved.index');
    Route::post('/events/{event}/save', [SponsorSavedEventController::class, 'store'])->name('events.save');
    Route::delete('/events/{event}/save', [SponsorSavedEventController::class, 'destroy'])->name('events.unsave');
    Route::post('/events/{event}/toggle-save', [SponsorSavedEventController::class, 'toggle'])->name('events.toggle-save');
    Route::post('/events/{event}/request', [SponsorEventController::class, 'requestSponsorship'])->name('events.request');

    // Compare Events
    Route::get('/compare', [SponsorCompareController::class, 'index'])->name('compare.index');
    Route::get('/compare/{comparison}', [SponsorCompareController::class, 'show'])->name('compare.show');
    Route::post('/compare', [SponsorCompareController::class, 'store'])->name('compare.store');
    Route::post('/compare/{comparison}/add-event', [SponsorCompareController::class, 'addEvent'])->name('compare.add-event');
    Route::delete('/compare/{comparison}/events/{event}', [SponsorCompareController::class, 'removeEvent'])->name('compare.remove-event');
    Route::delete('/compare/{comparison}', [SponsorCompareController::class, 'destroy'])->name('compare.destroy');

    // Proposals (full state machine)
    Route::get('/proposals', [SponsorProposalController::class, 'index'])->name('proposals.index');
    Route::get('/proposals/create/{event}', [SponsorProposalController::class, 'create'])->name('proposals.create');
    Route::post('/events/{event}/proposals', [SponsorProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}', [SponsorProposalController::class, 'show'])->name('proposals.show');
    Route::post('/proposals/{proposal}/submit', [SponsorProposalController::class, 'submit'])->name('proposals.submit');
    Route::post('/proposals/{proposal}/withdraw', [SponsorProposalController::class, 'withdraw'])->name('proposals.withdraw');
    Route::post('/proposals/{proposal}/accept-counter', [SponsorProposalController::class, 'acceptCounter'])->name('proposals.accept-counter');
    Route::post('/proposals/{proposal}/counter', [SponsorProposalController::class, 'counterOffer'])->name('proposals.counter');

    // Budget Management
    Route::get('/budget', [SponsorBudgetController::class, 'index'])->name('budget.index');
    Route::post('/budget', [SponsorBudgetController::class, 'store'])->name('budget.store');
    Route::put('/budget/{budget}', [SponsorBudgetController::class, 'update'])->name('budget.update');

    // Campaigns
    Route::get('/campaigns', [SponsorCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [SponsorCampaignController::class, 'show'])->name('campaigns.show');
    Route::post('/campaigns/{campaign}', [SponsorCampaignController::class, 'update'])->name('campaigns.update');
    Route::post('/campaigns/{campaign}/deliverables', [SponsorCampaignController::class, 'storeDeliverable'])->name('campaigns.deliverables.store');
    Route::post('/deliverables/{deliverable}', [SponsorCampaignController::class, 'updateDeliverable'])->name('campaigns.deliverables.update');

    // Contracts
    Route::get('/contracts', [SponsorContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [SponsorContractController::class, 'show'])->name('contracts.show');
    Route::post('/contracts/{contract}/sign', [SponsorContractController::class, 'sign'])->name('contracts.sign');
    Route::post('/contracts/{contract}/amendments', [SponsorContractController::class, 'storeAmendment'])->name('contracts.amendments.store');

    // Invoices & Finance
    Route::get('/invoices', [SponsorInvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [SponsorInvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/pay', [SponsorInvoiceController::class, 'pay'])->name('invoices.pay');

    // Teams
    Route::get('/teams', [SponsorTeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [SponsorTeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/{team}/members', [SponsorTeamController::class, 'addMember'])->name('teams.members.store');
    Route::delete('/teams/{team}/members/{member}', [SponsorTeamController::class, 'removeMember'])->name('teams.members.destroy');

    // Tasks
    Route::get('/tasks', [SponsorTaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [SponsorTaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/{task}', [SponsorTaskController::class, 'update'])->name('tasks.update');

    // Brand Assets
    Route::get('/brand-assets', [SponsorBrandAssetController::class, 'index'])->name('brand-assets.index');
    Route::post('/brand-assets/brands', [SponsorBrandAssetController::class, 'storeBrand'])->name('brand-assets.brands.store');
    Route::post('/brand-assets/assets', [SponsorBrandAssetController::class, 'storeAsset'])->name('brand-assets.assets.store');

    // Announcements
    Route::get('/announcements', [SponsorAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [SponsorAnnouncementController::class, 'store'])->name('announcements.store');
    Route::post('/announcements/{announcement}/publish', [SponsorAnnouncementController::class, 'publish'])->name('announcements.publish');

    // Documents
    Route::get('/documents', [SponsorDocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [SponsorDocumentController::class, 'store'])->name('documents.store');
    Route::post('/documents/{document}/finalize', [SponsorDocumentController::class, 'finalize'])->name('documents.finalize');

    // Integrations
    Route::get('/integrations', [SponsorIntegrationController::class, 'index'])->name('integrations.index');
    Route::post('/integrations', [SponsorIntegrationController::class, 'store'])->name('integrations.store');
    Route::post('/integrations/{integration}/disconnect', [SponsorIntegrationController::class, 'disconnect'])->name('integrations.disconnect');

    // Audit Logs
    Route::get('/audit-logs', [SponsorAuditLogController::class, 'index'])->name('audit-logs.index');

    // ROI & Performance Dashboard
    Route::get('/analytics', [SponsorAnalyticsController::class, 'index'])->name('analytics.index');

    // Reports
    Route::get('/reports', [SponsorReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{type}', [SponsorReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{type}/export', [SponsorReportController::class, 'export'])->name('reports.export');

    // Message Center
    Route::get('/messages', [SponsorMessageCenterController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [SponsorMessageCenterController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [SponsorMessageCenterController::class, 'store'])->name('messages.store');

    // Deal Pipeline (Kanban)
    Route::get('/pipeline', [SponsorPipelineController::class, 'index'])->name('pipeline.index');

    // AI Opportunity Matching
    Route::get('/ai-matching', [SponsorAIMatchingController::class, 'index'])->name('ai-matching.index');

    // Security Settings
    Route::get('/settings/security', [SponsorSecuritySettingsController::class, 'index'])->name('settings.security');
    Route::post('/settings/api-keys', [SponsorSecuritySettingsController::class, 'storeApiKey'])->name('settings.api-keys.store');
    Route::delete('/settings/api-keys/{integration}', [SponsorSecuritySettingsController::class, 'revokeApiKey'])->name('settings.api-keys.revoke');
    Route::post('/settings/two-factor', [SponsorSecuritySettingsController::class, 'updateTwoFactor'])->name('settings.two-factor');
    Route::post('/settings/sso', [SponsorSecuritySettingsController::class, 'updateSso'])->name('settings.sso');

    // Settings (Org Profile + Brand Profile)
    Route::get('/settings', [SponsorSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update-org', [SponsorSettingsController::class, 'updateOrg'])->name('settings.update-org');
    Route::post('/settings/brands', [SponsorSettingsController::class, 'storeBrand'])->name('settings.brands.store');
    Route::post('/settings/brands/{brand}', [SponsorSettingsController::class, 'updateBrand'])->name('settings.brands.update');
    Route::delete('/settings/brands/{brand}', [SponsorSettingsController::class, 'deleteBrand'])->name('settings.brands.delete');

    // Negotiation Center
    Route::get('/negotiations', [SponsorNegotiationController::class, 'index'])->name('negotiations.index');
    Route::get('/negotiations/{negotiation}', [SponsorNegotiationController::class, 'show'])->name('negotiations.show');
    Route::post('/negotiations/{negotiation}/rounds', [SponsorNegotiationController::class, 'storeRound'])->name('negotiations.rounds.store');
    Route::post('/negotiations/{negotiation}/accept', [SponsorNegotiationController::class, 'accept'])->name('negotiations.accept');
    Route::post('/negotiations/{negotiation}/decline', [SponsorNegotiationController::class, 'decline'])->name('negotiations.decline');

    // Notifications
    Route::get('/notifications', [SponsorNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [SponsorNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [SponsorNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/dismiss', [SponsorNotificationController::class, 'dismiss'])->name('notifications.dismiss');

    // Legacy requests (redirect to new proposals)
    Route::resource('requests', SponsorRequestController::class)->only(['index', 'show']);
});

// Payment / Checkout Routes (any authenticated payer)
Route::middleware('auth')->prefix('payments')->name('payments.')->group(function () {
    Route::get('/checkout/{sponsorshipRequest}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::match(['get', 'post'], '/callback/{payment}', [PaymentController::class, 'callback'])->name('callback');
    Route::get('/receipt/{payment}', [PaymentController::class, 'receipt'])->name('receipt');
});

// Payment Webhooks (gateway -> server; no auth, CSRF-exempt via bootstrap/app.php)
Route::post('/webhooks/payments/{gateway}', [PaymentWebhookController::class, 'handle'])
    ->name('webhooks.payments');

// Partner Routes
Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {
    // Workspace Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Partner\DashboardController::class, 'index'])->name('dashboard');

    // Service Marketplace (existing)
    Route::resource('services', PartnerServiceController::class);
    Route::get('/saved', [PartnerServiceController::class, 'saved'])->name('saved.index');
    Route::get('/opportunities', [PartnerBidController::class, 'opportunities'])->name('opportunities');
    Route::resource('bids', PartnerBidController::class)->only(['index', 'show', 'store']);

    // Assigned Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');

    // Leads
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/leads/{id}/stage', [LeadController::class, 'updateStage'])->name('leads.update-stage');

    // Deals
    Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
    Route::get('/deals/create', [DealController::class, 'create'])->name('deals.create');
    Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
    Route::get('/deals/{id}', [DealController::class, 'show'])->name('deals.show');
    Route::post('/deals/{id}/stage', [DealController::class, 'updateStage'])->name('deals.update-stage');

    // Meetings
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/meetings/{id}', [MeetingController::class, 'show'])->name('meetings.show');
    Route::post('/meetings/{id}/status', [MeetingController::class, 'updateStatus'])->name('meetings.update-status');

    // Campaigns
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::post('/campaigns/{id}/status', [CampaignController::class, 'updateStatus'])->name('campaigns.update-status');

    // Commissions
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // AI Copilot
    Route::get('/ai-copilot', [AICopilotController::class, 'index'])->name('ai-copilot.index');
    Route::post('/ai-copilot/score-lead', [AICopilotController::class, 'scoreLead'])->name('ai-copilot.score-lead');

    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

    // Social Account Management
    Route::get('/social', [SocialAccountController::class, 'index'])->name('social.index');
    Route::get('/social/{provider}/connect', [SocialAccountController::class, 'connect'])->name('social.connect');
    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'callback'])->name('social.callback');
    Route::delete('/social/{provider}/disconnect', [SocialAccountController::class, 'disconnect'])->name('social.disconnect');
    Route::get('/social/status', [SocialAccountController::class, 'status'])->name('social.status');

    // Social Posts
    Route::get('/posts', [SocialPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [SocialPostController::class, 'show'])->name('posts.show');
    Route::post('/events/{event}/posts', [SocialPostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/publish', [SocialPostController::class, 'publish'])->name('posts.publish');
    Route::delete('/posts/{post}', [SocialPostController::class, 'destroy'])->name('posts.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Events (with detailed sub-controllers)
    Route::get('/events', [AdminEventController::class, 'index'])->name('events');
    Route::get('/events/pending', [AdminEventController::class, 'pending'])->name('events.pending');
    Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/approve', [AdminEventController::class, 'approve'])->name('events.approve');
    Route::post('/events/{event}/reject', [AdminEventController::class, 'reject'])->name('events.reject');

    // Event Dates & Venues (organizer-facing but managed by admin)
    Route::resource('event-dates', AdminEventDateController::class);
    Route::resource('event-venues', AdminEventVenueController::class);
    Route::resource('event-teams', AdminEventTeamController::class);
    Route::resource('event-schedules', AdminEventScheduleController::class);

    // Event Schedules (from above)

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/verify', [AdminUserController::class, 'verify'])->name('users.verify');
    Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Sponsorships
    Route::get('/sponsorships', [AdminSponsorshipController::class, 'index'])->name('sponsorships');
    Route::resource('sponsorship-packages', AdminSponsorshipPackageController::class);

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');

    // Organizers
    Route::get('/organizers', [AdminOrganizerController::class, 'index'])->name('organizers.index');
    Route::get('/organizers/{organizer}', [AdminOrganizerController::class, 'show'])->name('organizers.show');
    Route::post('/organizers/{organizer}/profile', [AdminOrganizerController::class, 'updateProfile'])->name('organizers.update-profile');

    // Event Schedules (nested under events)
    Route::get('/events/{event}/schedules', [AdminOrganizerEventScheduleController::class, 'index'])->name('events.schedules');
    Route::post('/events/{event}/schedules', [AdminOrganizerEventScheduleController::class, 'store'])->name('events.schedules.store');
    Route::delete('/events/{event}/schedules/{schedule}', [AdminOrganizerEventScheduleController::class, 'destroy'])->name('events.schedules.destroy');

    // Event Gallery
    Route::get('/events/{event}/gallery', [AdminOrganizerEventGalleryController::class, 'index'])->name('events.gallery');
    Route::post('/events/{event}/gallery', [AdminOrganizerEventGalleryController::class, 'store'])->name('events.gallery.store');
    Route::delete('/events/{event}/gallery/{gallery}', [AdminOrganizerEventGalleryController::class, 'destroy'])->name('events.gallery.destroy');

    // Event Team
    Route::get('/events/{event}/team', [AdminOrganizerEventTeamController::class, 'index'])->name('events.team');
    Route::post('/events/{event}/team', [AdminOrganizerEventTeamController::class, 'store'])->name('events.team.store');
    Route::delete('/events/{event}/team/{team}', [AdminOrganizerEventTeamController::class, 'destroy'])->name('events.team.destroy');

    // Contracts
    Route::get('/contracts', [AdminOrganizerContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [AdminOrganizerContractController::class, 'show'])->name('contracts.show');
    Route::patch('/contracts/{contract}/status', [AdminOrganizerContractController::class, 'updateStatus'])->name('contracts.update-status');

    // SRM (Sponsor Relationships)
    Route::get('/srm', [AdminOrganizerSRMController::class, 'index'])->name('srm.index');
    Route::get('/srm/{relationship}', [AdminOrganizerSRMController::class, 'show'])->name('srm.show');

    // Renewals
    Route::get('/renewals', [AdminOrganizerRenewalController::class, 'index'])->name('renewals.index');
    Route::get('/renewals/{renewal}', [AdminOrganizerRenewalController::class, 'show'])->name('renewals.show');

    // Post-Event Reports
    Route::get('/post-events', [AdminOrganizerPostEventController::class, 'index'])->name('post-events.index');
    Route::get('/post-events/{report}', [AdminOrganizerPostEventController::class, 'show'])->name('post-events.show');

    // Social Accounts & Posts
    Route::get('/social/accounts', [AdminOrganizerSocialController::class, 'accounts'])->name('social.accounts');
    Route::get('/social/posts', [AdminOrganizerSocialController::class, 'posts'])->name('social.posts');
    Route::get('/social/posts/{post}', [AdminOrganizerSocialController::class, 'showPost'])->name('social.posts.show');

    // Partners
    Route::get('/partners', [AdminPartnerController::class, 'index'])->name('partners');
    Route::post('/partners/{partner}/verify', [AdminPartnerController::class, 'verify'])->name('partners.verify');

    // Partner Services
    Route::get('/partner-services', [AdminPartnerServiceController::class, 'index'])->name('partner-services.index');
    Route::get('/partner-services/{service}', [AdminPartnerServiceController::class, 'show'])->name('partner-services.show');
    Route::post('/partner-services/{service}/toggle', [AdminPartnerServiceController::class, 'toggle'])->name('partner-services.toggle');
    Route::delete('/partner-services/{service}', [AdminPartnerServiceController::class, 'destroy'])->name('partner-services.destroy');

    // Partner Bids
    Route::get('/partner-bids', [AdminPartnerBidController::class, 'index'])->name('partner-bids.index');
    Route::get('/partner-bids/{bid}', [AdminPartnerBidController::class, 'show'])->name('partner-bids.show');

    // Partner Leads
    Route::get('/partner-leads', [AdminPartnerLeadController::class, 'index'])->name('partner-leads.index');
    Route::get('/partner-leads/{lead}', [AdminPartnerLeadController::class, 'show'])->name('partner-leads.show');

    // Partner Deals
    Route::get('/partner-deals', [AdminPartnerDealController::class, 'index'])->name('partner-deals.index');
    Route::get('/partner-deals/{deal}', [AdminPartnerDealController::class, 'show'])->name('partner-deals.show');

    // Partner Campaigns
    Route::get('/partner-campaigns', [AdminPartnerCampaignController::class, 'index'])->name('partner-campaigns.index');
    Route::get('/partner-campaigns/{campaign}', [AdminPartnerCampaignController::class, 'show'])->name('partner-campaigns.show');

    // Partner Meetings
    Route::get('/partner-meetings', [AdminPartnerMeetingController::class, 'index'])->name('partner-meetings.index');
    Route::get('/partner-meetings/{meeting}', [AdminPartnerMeetingController::class, 'show'])->name('partner-meetings.show');

    // Partner Tasks
    Route::get('/partner-tasks', [AdminPartnerTaskController::class, 'index'])->name('partner-tasks.index');
    Route::get('/partner-tasks/{task}', [AdminPartnerTaskController::class, 'show'])->name('partner-tasks.show');

    // Partner Commissions
    Route::get('/partner-commissions', [AdminPartnerCommissionController::class, 'index'])->name('partner-commissions.index');

    // Partner Client Assignments
    Route::get('/partner-clients', [AdminPartnerClientController::class, 'index'])->name('partner-clients.index');
    Route::get('/partner-clients/{assignment}', [AdminPartnerClientController::class, 'show'])->name('partner-clients.show');

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/{type}', [AdminReportController::class, 'show'])->name('reports.show');

    // CMS
    Route::get('/cms', [AdminCmsController::class, 'index'])->name('cms');
    Route::get('/cms/create', [AdminCmsController::class, 'create'])->name('cms.create');
    Route::post('/cms', [AdminCmsController::class, 'store'])->name('cms.store');
    Route::get('/cms/{cmsPage}/edit', [AdminCmsController::class, 'edit'])->name('cms.edit');
    Route::put('/cms/{cmsPage}', [AdminCmsController::class, 'update'])->name('cms.update');
    Route::delete('/cms/{cmsPage}', [AdminCmsController::class, 'destroy'])->name('cms.destroy');

    // Roles & Permissions
    Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles');
    Route::post('/roles', [AdminRoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [AdminRoleController::class, 'update'])->name('roles.update');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/cache', [AdminSettingController::class, 'clearCache'])->name('settings.cache');
    Route::post('/settings/backup', [AdminSettingController::class, 'runBackup'])->name('settings.backup');

    // Activity Logs
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs');

    // SEO Management
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/dashboard', [AdminSeoDashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [AdminSeoSettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [AdminSeoSettingsController::class, 'store'])->name('settings.store');
        Route::get('/audit', [AdminSeoAuditController::class, 'index'])->name('audit');
        Route::get('/audit/{auditable_type}/{auditable_id}', [AdminSeoAuditController::class, 'show'])->name('audit.show');
        Route::post('/schedule-scan', [AdminSeoAuditController::class, 'scheduleScan'])->name('schedule-scan');
        Route::get('/sitemap', [AdminSitemapController::class, 'index'])->name('sitemap');
        Route::get('/sitemap/generate', [AdminSitemapController::class, 'generate'])->name('sitemap.generate');
        Route::get('/sitemap/download', [AdminSitemapController::class, 'download'])->name('sitemap.download');
        Route::get('/robots', [AdminRobotsController::class, 'index'])->name('robots');
        Route::put('/robots', [AdminRobotsController::class, 'update'])->name('robots.update');
        Route::get('/redirects', [AdminRedirectController::class, 'index'])->name('redirects');
        Route::post('/redirects', [AdminRedirectController::class, 'store'])->name('redirects.store');
        Route::put('/redirects/{redirect}', [AdminRedirectController::class, 'update'])->name('redirects.update');
        Route::delete('/redirects/{redirect}', [AdminRedirectController::class, 'destroy'])->name('redirects.destroy');
        Route::get('/schema', [AdminSchemaController::class, 'index'])->name('schema');
        Route::post('/schema/validate', [AdminSchemaController::class, 'check'])->name('schema.validate');
    });
});

// Fallback storage URL server (when public/storage symlink does not exist)
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/'.$path);
    if (!file_exists($fullPath)) abort(404);
    return response()->file($fullPath);
})->where('path', '.*');

// Setup storage symlink (visit once to fix image serving)
Route::get('/setup-storage', function () {
    $link = public_path('storage');
    $target = storage_path('app/public');
    if (is_link($link) || file_exists($link)) {
        return 'Storage link already exists.';
    }
    try {
        symlink($target, $link);
        return 'Storage symlink created successfully! <a href="/">Go to homepage</a>';
    } catch (\Throwable $e) {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = [];
            $cmd = sprintf('mklink /D "%s" "%s"', $link, $target);
            exec($cmd, $output, $exitCode);
            if ($exitCode === 0) {
                return 'Storage symlink created via mklink! <a href="/">Go to homepage</a>';
            }
            return 'Failed to create symlink. Run this command as Administrator:<br><code>mklink /D "'.addslashes($link).'" "'.addslashes($target).'"</code>';
        }
        return 'Failed to create symlink. Run: php artisan storage:link<br>Error: '.$e->getMessage();
    }
})->middleware('web');

require __DIR__.'/auth.php';
