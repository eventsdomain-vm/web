<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryFieldDefinition;
use Illuminate\Database\Seeder;

class CategoryFieldDefinitionSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // GLOBAL DEFAULTS (category_id = NULL) — applied to ALL categories
        // unless overridden by a category-specific row.
        // =====================================================================
        $globalFields = [
            // ── Basic Info ──────────────────────────────────────────────
            ['section_key' => 'basic', 'field_key' => 'title', 'label' => 'Event Title', 'input_type' => 'text', 'is_visible' => true, 'is_required' => true, 'sort_order' => 1],
            ['section_key' => 'basic', 'field_key' => 'tagline', 'label' => 'Tagline', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 2],
            ['section_key' => 'basic', 'field_key' => 'description', 'label' => 'Description', 'input_type' => 'textarea', 'is_visible' => true, 'is_required' => true, 'sort_order' => 3],
            ['section_key' => 'basic', 'field_key' => 'category_id', 'label' => 'Category', 'input_type' => 'select', 'is_visible' => true, 'is_required' => true, 'sort_order' => 4],
            ['section_key' => 'basic', 'field_key' => 'event_type', 'label' => 'Event Type', 'input_type' => 'select', 'is_visible' => true, 'is_required' => true, 'options' => ['physical' => 'In-Person', 'virtual' => 'Virtual', 'hybrid' => 'Hybrid'], 'sort_order' => 5],
            ['section_key' => 'basic', 'field_key' => 'visibility', 'label' => 'Visibility', 'input_type' => 'select', 'is_visible' => true, 'is_required' => true, 'options' => ['public' => 'Public', 'unlisted' => 'Unlisted', 'private' => 'Private'], 'sort_order' => 6],

            // ── Dates & Schedule ────────────────────────────────────────
            ['section_key' => 'dates', 'field_key' => 'start_date', 'label' => 'Start Date', 'input_type' => 'date', 'is_visible' => true, 'is_required' => true, 'sort_order' => 1],
            ['section_key' => 'dates', 'field_key' => 'end_date', 'label' => 'End Date', 'input_type' => 'date', 'is_visible' => true, 'is_required' => true, 'sort_order' => 2],
            ['section_key' => 'dates', 'field_key' => 'start_time', 'label' => 'Start Time', 'input_type' => 'time', 'is_visible' => true, 'is_required' => false, 'sort_order' => 3],
            ['section_key' => 'dates', 'field_key' => 'end_time', 'label' => 'End Time', 'input_type' => 'time', 'is_visible' => true, 'is_required' => false, 'sort_order' => 4],
            ['section_key' => 'dates', 'field_key' => 'registration_deadline', 'label' => 'Registration Deadline', 'input_type' => 'date', 'is_visible' => true, 'is_required' => false, 'sort_order' => 5],

            // ── Venue & Location ────────────────────────────────────────
            ['section_key' => 'venue', 'field_key' => 'venue', 'label' => 'Venue Name', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 1],
            ['section_key' => 'venue', 'field_key' => 'address', 'label' => 'Venue Address', 'input_type' => 'textarea', 'is_visible' => true, 'is_required' => false, 'sort_order' => 2],
            ['section_key' => 'venue', 'field_key' => 'city', 'label' => 'City', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 3],
            ['section_key' => 'venue', 'field_key' => 'state', 'label' => 'State', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 4],
            ['section_key' => 'venue', 'field_key' => 'country', 'label' => 'Country', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 5],

            // ── Sponsorship & Budget ────────────────────────────────────
            ['section_key' => 'sponsorship', 'field_key' => 'sponsorship_type', 'label' => 'Sponsorship Type', 'input_type' => 'select', 'is_visible' => true, 'is_required' => true, 'options' => ['paid' => 'Paid', 'barter' => 'Barter', 'hybrid' => 'Paid + Barter'], 'sort_order' => 1],
            ['section_key' => 'sponsorship', 'field_key' => 'budget_min', 'label' => 'Minimum Budget', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 2],
            ['section_key' => 'sponsorship', 'field_key' => 'budget_max', 'label' => 'Maximum Budget', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 3],
            ['section_key' => 'sponsorship', 'field_key' => 'currency', 'label' => 'Currency', 'input_type' => 'select', 'is_visible' => true, 'is_required' => true, 'options' => ['INR' => 'INR', 'USD' => 'USD', 'EUR' => 'EUR', 'GBP' => 'GBP'], 'sort_order' => 4],

            // ── Audience ────────────────────────────────────────────────
            ['section_key' => 'audience', 'field_key' => 'expected_audience', 'label' => 'Expected Audience Size', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 1],
            ['section_key' => 'audience', 'field_key' => 'audience_description', 'label' => 'Audience Description', 'input_type' => 'textarea', 'is_visible' => true, 'is_required' => false, 'sort_order' => 2],

            // ── Media ──────────────────────────────────────────────────
            ['section_key' => 'media', 'field_key' => 'logo', 'label' => 'Event Logo', 'input_type' => 'media', 'is_visible' => true, 'is_required' => false, 'sort_order' => 1],
            ['section_key' => 'media', 'field_key' => 'cover_image', 'label' => 'Cover Image', 'input_type' => 'media', 'is_visible' => true, 'is_required' => false, 'sort_order' => 2],
            ['section_key' => 'media', 'field_key' => 'banner_image', 'label' => 'Banner Image', 'input_type' => 'media', 'is_visible' => true, 'is_required' => false, 'sort_order' => 3],
            ['section_key' => 'media', 'field_key' => 'website_url', 'label' => 'Website URL', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 4],
            ['section_key' => 'media', 'field_key' => 'video_url', 'label' => 'Video URL', 'input_type' => 'text', 'is_visible' => true, 'is_required' => false, 'sort_order' => 5],

            // ── Tags ───────────────────────────────────────────────────
            ['section_key' => 'tags', 'field_key' => 'tags', 'label' => 'Event Tags', 'input_type' => 'multiselect', 'is_visible' => true, 'is_required' => false, 'sort_order' => 1],
        ];

        foreach ($globalFields as $field) {
            CategoryFieldDefinition::create($field + ['category_id' => null]);
        }

        // =====================================================================
        // CATEGORY-SPECIFIC OVERRIDES
        // Only fields that differ from the global defaults for that category.
        // =====================================================================

        // Sports & Fitness — requires audience description, adds sport-specific fields
        $sports = Category::where('name', 'Sports & Fitness')->first();
        if ($sports) {
            $overrides = [
                ['section_key' => 'audience', 'field_key' => 'audience_description', 'label' => 'Target Audience & Sport Type', 'input_type' => 'textarea', 'is_visible' => true, 'is_required' => true, 'sort_order' => 2],
                ['section_key' => 'sponsorship', 'field_key' => 'minimum_sponsorship', 'label' => 'Minimum Sponsorship Amount', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 5],
                ['section_key' => 'sponsorship', 'field_key' => 'maximum_sponsorship', 'label' => 'Maximum Sponsorship Amount', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 6],
            ];
            foreach ($overrides as $field) {
                CategoryFieldDefinition::create($field + ['category_id' => $sports->id]);
            }
        }

        // Music & Entertainment — adds lineup/rehearsal fields
        $music = Category::where('name', 'Music & Entertainment')->first();
        if ($music) {
            $overrides = [
                ['section_key' => 'basic', 'field_key' => 'description', 'label' => 'Event Description & Lineup', 'input_type' => 'textarea', 'is_visible' => true, 'is_required' => true, 'sort_order' => 3],
                ['section_key' => 'dates', 'field_key' => 'rehearsal_date', 'label' => 'Rehearsal Date', 'input_type' => 'date', 'is_visible' => true, 'is_required' => false, 'sort_order' => 6],
            ];
            foreach ($overrides as $field) {
                CategoryFieldDefinition::create($field + ['category_id' => $music->id]);
            }
        }

        // Technology — adds tech stack fields
        $tech = Category::where('name', 'Technology')->first();
        if ($tech) {
            $overrides = [
                ['section_key' => 'basic', 'field_key' => 'tech_stack', 'label' => 'Tech Stack / Focus Areas', 'input_type' => 'multiselect', 'is_visible' => true, 'is_required' => false, 'sort_order' => 7, 'options' => ['AI/ML', 'Web3', 'Cloud', 'DevOps', 'Mobile', 'Data Science', 'Cybersecurity']],
            ];
            foreach ($overrides as $field) {
                CategoryFieldDefinition::create($field + ['category_id' => $tech->id]);
            }
        }

        // Education — adds academic fields
        $edu = Category::where('name', 'Education')->first();
        if ($edu) {
            $overrides = [
                ['section_key' => 'basic', 'field_key' => 'certification_offered', 'label' => 'Certification Offered', 'input_type' => 'boolean', 'is_visible' => true, 'is_required' => false, 'sort_order' => 7],
                ['section_key' => 'basic', 'field_key' => 'credits', 'label' => 'Credits / CPD Points', 'input_type' => 'number', 'is_visible' => true, 'is_required' => false, 'sort_order' => 8],
            ];
            foreach ($overrides as $field) {
                CategoryFieldDefinition::create($field + ['category_id' => $edu->id]);
            }
        }
    }
}
