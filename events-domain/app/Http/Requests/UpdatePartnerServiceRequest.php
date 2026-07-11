<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly,negotiable',
            'pricing_model' => 'required|in:cost,barter,hybrid',
            'is_available' => 'nullable|boolean',
            'min_notice_days' => 'nullable|integer|min:0|max:365',
            'portfolio_images' => 'nullable|array',
            'portfolio_images.*' => 'image|mimes:jpeg,png,webp|max:2048',
        ];
    }
}
