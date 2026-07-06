<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'tagline' => 'nullable|string|max:500',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'event_type' => 'sometimes|in:physical,virtual,hybrid',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'venue' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:500',
            'city' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'country' => 'sometimes|string|max:100',
            'website_url' => 'sometimes|url|max:500',
            'registration_deadline' => 'sometimes|date',
            'expected_audience' => 'sometimes|integer|min:1',
            'budget_min' => 'sometimes|numeric|min:0',
            'budget_max' => 'sometimes|numeric|gte:budget_min',
            'sponsorship_type' => 'sometimes|string|in:paid,barter,hybrid',
            'tags' => 'sometimes|string|max:500',
            'audience_description' => 'sometimes|string|max:2000',
            'video_url' => 'sometimes|url|max:500',
            'logo' => 'sometimes|image|mimes:jpeg,png,webp|max:2048',
            'cover_image' => 'sometimes|image|mimes:jpeg,png,webp|max:2048',
            'banner_image' => 'sometimes|image|mimes:jpeg,png,webp|max:2048',
            'audience_age_groups' => 'sometimes|array',
            'audience_gender' => 'sometimes|array',
            'audience_income' => 'sometimes|array',
            'audience_industries' => 'sometimes|array',
            'audience_reach' => 'sometimes|string|in:Local,Regional,National,International',
            'addons' => 'sometimes|array',
            'dates' => 'sometimes|array',
            'dates.*.label' => 'nullable|string|max:255',
            'dates.*.start_date' => 'required_with:dates|date',
            'dates.*.end_date' => 'nullable|date|gte:dates.*.start_date',
            'dates.*.start_time' => 'nullable|date_format:H:i',
            'dates.*.end_time' => 'nullable|date_format:H:i',
            'dates.*.timezone' => 'nullable|string|max:50',
            'dates.*.all_day' => 'sometimes|boolean',
            'venues' => 'sometimes|array',
            'venues.*.venue_type' => 'sometimes|in:physical,virtual',
            'venues.*.venue_name' => 'nullable|string|max:255',
            'venues.*.address' => 'nullable|string|max:500',
            'venues.*.city' => 'nullable|string|max:100',
            'venues.*.state' => 'nullable|string|max:100',
            'venues.*.country' => 'nullable|string|max:100',
            'venues.*.postal_code' => 'nullable|string|max:20',
            'venues.*.latitude' => 'nullable|numeric|between:-90,90',
            'venues.*.longitude' => 'nullable|numeric|between:-180,180',
            'venues.*.virtual_url' => 'nullable|url|max:500',
            'venues.*.virtual_platform' => 'nullable|string|max:100',
            'venues.*.is_primary' => 'sometimes|boolean',
            'packages' => 'sometimes|array',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
            'packages.*.description' => 'nullable|string|max:2000',
            'packages.*.benefits' => 'nullable|string',
            'packages.*.slots_available' => 'nullable|integer|min:1',
        ];
    }
}
