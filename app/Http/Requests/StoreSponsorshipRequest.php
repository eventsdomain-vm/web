<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'package_id' => 'required|exists:sponsor_packages,id',
            'custom_proposal' => 'nullable|string|max:5000',
            'budget_offer' => 'nullable|numeric|min:0',
            'message' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Please select an event.',
            'event_id.exists' => 'Selected event does not exist.',
            'package_id.required' => 'Please select a sponsorship package.',
            'package_id.exists' => 'Selected package does not exist.',
        ];
    }
}
