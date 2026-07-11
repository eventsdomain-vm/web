<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'event_type' => 'required|in:in-person,virtual,hybrid',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website_url' => 'nullable|url|max:500',
            'contact_no' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:255',
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
            'budget_max.gte' => 'Maximum budget must be greater than or equal to minimum budget.',
        ];
    }
}
