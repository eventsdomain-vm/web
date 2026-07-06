<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $profile = PartnerProfile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);

        return view('partner.settings.index', compact('profile'));
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
            'company_name' => 'nullable|string|max:255',
            'company_type' => 'nullable|string|max:50',
            'designation' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'years_of_experience' => 'nullable|integer|min:0|max:100',
            'team_size' => 'nullable|integer|min:0|max:10000',
            'bio' => 'nullable|string|max:5000',
            'gst_number' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'official_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:500',
            'social_media_link' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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

        if ($request->hasFile('company_logo')) {
            $profileData['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        if ($request->has('client_references')) {
            $refs = array_values(array_filter($request->input('client_references', []), fn ($r) => !empty($r['name']) || !empty($r['mobile']) || !empty($r['email'])));
            $profileData['client_references'] = !empty($refs) ? $refs : null;
        }

        PartnerProfile::updateOrCreate(['user_id' => $user->id], $profileData);

        $socialLinks = $request->only(['social_profile_facebook', 'social_profile_linkedin', 'social_profile_instagram', 'social_profile_youtube']);
        if (array_filter($socialLinks)) {
            $profile = $user->profile ?? $user->profile()->create(['role_type' => 'partner']);
            $profile->update(['social_links' => array_merge($profile->social_links ?? [], $socialLinks)]);
        }

        return redirect()->route('partner.settings.index')->with('success', 'Profile updated successfully.');
    }

    private function ensureProfileColumns(): void
    {
        if (Schema::hasColumn('partner_profiles', 'designation')) return;

        Schema::table('partner_profiles', function ($table) {
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
}
