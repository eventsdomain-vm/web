<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\OrganizerProfile;
use App\Models\OrganizerSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = OrganizerProfile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
        $settings = OrganizerSetting::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);

        return view('organizer.profile.index', compact('profile', 'settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Profile tab
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'social_profile_facebook' => 'nullable|url|max:500',
            'social_profile_linkedin' => 'nullable|url|max:500',
            'social_profile_instagram' => 'nullable|url|max:500',
            'social_profile_youtube' => 'nullable|url|max:500',
            // Organization tab
            'organization_name' => 'nullable|string|max:255',
            'company_type' => 'nullable|string|max:50',
            'designation' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'founded_year' => 'nullable|integer|min:1900|max:2100',
            'bio' => 'nullable|string|max:5000',
            'gst_number' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'official_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:500',
            'social_media_link' => 'nullable|url|max:500',
            'organization_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // Verification tab
            'client_references' => 'nullable|array|max:5',
            'client_references.*.name' => 'nullable|string|max:255',
            'client_references.*.mobile' => 'nullable|string|max:20',
            'client_references.*.email' => 'nullable|email|max:255',
        ]);

        $this->ensureProfileColumns();

        $user = Auth::user();
        $user->update($request->only(['name', 'phone']));

        if ($request->hasFile('avatar')) {
            $user->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);
        }

        $profileData = $request->except(['name', 'phone', 'avatar', 'social_profile_facebook', 'social_profile_linkedin', 'social_profile_instagram', 'social_profile_youtube', '_token', '_method']);

        if ($request->hasFile('organization_logo')) {
            $profileData['organization_logo'] = $request->file('organization_logo')->store('logos', 'public');
        }

        if ($request->has('client_references')) {
            $refs = array_values(array_filter($request->input('client_references', []), fn ($r) => !empty($r['name']) || !empty($r['mobile']) || !empty($r['email'])));
            $profileData['client_references'] = !empty($refs) ? $refs : null;
        }

        OrganizerProfile::updateOrCreate(['user_id' => $user->id], $profileData);

        // Store social profile URLs on the user's profile record
        $socialLinks = $request->only(['social_profile_facebook', 'social_profile_linkedin', 'social_profile_instagram', 'social_profile_youtube']);
        if (array_filter($socialLinks)) {
            $profile = $user->profile ?? $user->profile()->create(['role_type' => 'organizer']);
            $profile->update(['social_links' => array_merge($profile->social_links ?? [], $socialLinks)]);
        }

        return redirect()->route('organizer.profile.index')->with('success', 'Profile updated successfully.');
    }

    private function ensureProfileColumns(): void
    {
        if (Schema::hasColumn('organizer_profiles', 'designation')) return;

        Schema::table('organizer_profiles', function ($table) {
            $table->string('pincode', 20)->nullable()->after('country');
            $table->string('pan_no', 20)->nullable()->after('tax_id');
            $table->string('designation', 100)->nullable()->after('business_type');
            $table->string('gst_number', 20)->nullable()->after('pan_no');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->string('gst_legal_name')->nullable()->after('gst_verified');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_legal_name');
            $table->boolean('pan_verified')->default(false)->after('gst_verified_at');
            $table->timestamp('pan_verified_at')->nullable()->after('pan_verified');
            $table->string('official_email')->nullable()->after('website');
            $table->string('social_media_link', 500)->nullable()->after('official_email');
            $table->json('client_references')->nullable()->after('social_media_link');
        });
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'locale' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:3',
        ]);

        OrganizerSetting::updateOrCreate(['user_id' => Auth::id()], $validated);

        return redirect()->route('organizer.profile.index')->with('success', 'Settings updated.');
    }
}
