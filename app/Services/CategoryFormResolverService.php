<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\CategoryFieldDefinition;

/**
 * Resolves which form sections and fields should be displayed for a given
 * category during the event creation/edit wizard.
 *
 * Resolution logic:
 *  1. Start with global defaults (category_id IS NULL)
 *  2. Overlay category-specific overrides (matching category_id)
 *  3. Group by section_key, sort by sort_order
 *  4. Optionally filter to only visible fields
 *
 * Results are cached per category ID for 1 hour.
 */
class CategoryFormResolverService
{
    /**
     * Get the full resolved form schema for a category.
     *
     * @param  int|null  $categoryId  The category ID (null = global defaults only)
     * @param  bool  $visibleOnly  If true, strip hidden fields
     * @return array<string, array{section_key: string, fields: array<int, array>}> section_key → {section_key, fields}
     */
    public function resolve(?int $categoryId = null, bool $visibleOnly = true): array
    {
        $fieldDefs = CategoryFieldDefinition::resolveForCategory($categoryId);

        $sections = [];

        foreach ($fieldDefs as $sectionKey => $fields) {
            if ($visibleOnly) {
                $fields = array_filter($fields, fn ($f) => $f->is_visible);
            }

            if (empty($fields)) {
                continue;
            }

            $sections[$sectionKey] = [
                'section_key' => $sectionKey,
                'label' => $this->sectionLabel($sectionKey),
                'fields' => array_map(fn ($f) => $this->formatField($f), array_values($fields)),
            ];
        }

        return $sections;
    }

    /**
     * Get just the fields for a single section.
     *
     * @return array<int, array>
     */
    public function resolveSection(?int $categoryId, string $sectionKey, bool $visibleOnly = true): array
    {
        $all = $this->resolve($categoryId, $visibleOnly);

        return $all[$sectionKey]['fields'] ?? [];
    }

    /**
     * Get all available section keys for a category.
     *
     * @return array<int, string>
     */
    public function getSectionKeys(?int $categoryId = null): array
    {
        $sections = $this->resolve($categoryId);

        return array_keys($sections);
    }

    /**
     * Get the number of required fields for a category.
     */
    public function getRequiredFieldCount(?int $categoryId = null): int
    {
        $sections = $this->resolve($categoryId, false);
        $count = 0;

        foreach ($sections as $section) {
            foreach ($section['fields'] as $field) {
                if ($field['is_required']) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Build validation rules array from the resolved schema.
     *
     * @return array<string, string>
     */
    public function getValidationRules(?int $categoryId = null): array
    {
        $sections = $this->resolve($categoryId, false);
        $rules = [];

        foreach ($sections as $section) {
            foreach ($section['fields'] as $field) {
                $rule = $this->inputTypeToValidationRule($field['input_type']);
                if ($field['is_required']) {
                    $rule = str_replace('|', ',|', $rule);
                    if (! str_contains($rule, 'required')) {
                        $rule = 'required|'.$rule;
                    }
                } else {
                    $rule = 'nullable|'.$rule;
                }
                $rules[$field['field_key']] = $rule;
            }
        }

        return $rules;
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    private function formatField(CategoryFieldDefinition $field): array
    {
        return [
            'field_key' => $field->field_key,
            'label' => $field->label ?? $field->field_key,
            'input_type' => $field->input_type,
            'is_required' => $field->is_required,
            'is_visible' => $field->is_visible,
            'options' => $field->options,
            'sort_order' => $field->sort_order,
        ];
    }

    private function sectionLabel(string $key): string
    {
        return match ($key) {
            'basic' => 'Basic Information',
            'dates' => 'Dates & Schedule',
            'venue' => 'Venue & Location',
            'sponsorship' => 'Sponsorship & Budget',
            'audience' => 'Audience',
            'media' => 'Media & Links',
            'tags' => 'Tags',
            default => str_replace('_', ' ', ucfirst($key)),
        };
    }

    private function inputTypeToValidationRule(string $inputType): string
    {
        return match ($inputType) {
            'text' => 'string|max:500',
            'textarea' => 'string|max:10000',
            'number' => 'numeric|min:0',
            'date' => 'date',
            'time' => 'date_format:H:i',
            'select' => 'string',
            'multiselect' => 'array',
            'boolean' => 'boolean',
            'repeater' => 'array',
            'media' => 'string|max:500',
            default => 'string',
        };
    }
}
