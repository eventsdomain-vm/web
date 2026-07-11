<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:500',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'event_type' => 'required|in:physical,virtual,hybrid',
            'start_date' => 'required|date',
            'end_date' => 'required|date|gte:start_date',
            'venue' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website_url' => 'nullable|url|max:500',
            'registration_deadline' => 'nullable|date',
            'expected_audience' => 'nullable|integer|min:1',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|gte:budget_min',
            'sponsorship_type' => 'nullable|string|in:paid,barter,hybrid',
            'tags' => 'nullable|string|max:500',
            'audience_description' => 'nullable|string|max:2000',
            'video_url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'audience_age_groups' => 'nullable|array',
            'audience_gender' => 'nullable|array',
            'audience_income' => 'nullable|array',
            'audience_industries' => 'nullable|array',
            'audience_reach' => 'nullable|string|in:Local,Regional,National,International',
            'plan' => 'required|string|in:basic,featured,homepage',
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
            'participants' => 'sometimes|array',
            'participants.*.name' => 'required_with:participants|string|max:255',
            'participants.*.participant_type_id' => 'nullable|exists:participant_types,id',
            'participants.*.role_label' => 'nullable|string|max:255',
            'participants.*.session_title' => 'nullable|string|max:255',
            'participants.*.bio' => 'nullable|string|max:2000',
            'participants.*.organization' => 'nullable|string|max:255',
            'participants.*.designation' => 'nullable|string|max:255',
            'team' => 'sometimes|array',
            'team.*.user_id' => 'required_with:team|exists:users,id',
            'team.*.role' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter an event title.',
            'description.required' => 'Please provide an event description.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'event_type.required' => 'Please select an event type.',
            'start_date.required' => 'Please select a start date.',
            'end_date.required' => 'Please select an end date.',
            'end_date.gte' => 'End date must be after start date.',
            'budget_max.gte' => 'Maximum budget must be greater than or equal to minimum budget.',
            'plan.required' => 'Please select a subscription plan.',
        ];
    }
}
