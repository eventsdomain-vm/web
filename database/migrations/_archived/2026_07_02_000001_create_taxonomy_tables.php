<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Taxonomy & lookup tables: category hierarchy, the data-driven field-visibility
 * schema that powers category-aware forms (Task 6), and the amenity lookup.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Self-referencing 3-tier category taxonomy.
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->foreignId('parent_id')->nullable()
                ->constrained('categories')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('parent_id', 'idx_categories_parent_id');
            $table->index('is_active', 'idx_categories_is_active');
            $table->index('sort_order', 'idx_categories_sort_order');
        });

        // Data-driven form schema: which sections/fields a category shows,
        // whether required, and their input type. A NULL category_id row is a
        // global default; category-specific rows override it at resolve time.
        Schema::create('category_field_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()
                ->constrained('categories')->cascadeOnDelete();
            $table->string('section_key', 80);
            $table->string('field_key', 80)->nullable();
            $table->string('label', 150)->nullable();
            $table->enum('input_type', [
                'text', 'textarea', 'number', 'date', 'time', 'select',
                'multiselect', 'boolean', 'repeater', 'media',
            ])->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_required')->default(false);
            $table->json('options')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category_id', 'section_key', 'field_key'], 'uk_cfd_cat_section_field');
            $table->index('category_id', 'idx_cfd_category');
        });

        // Amenity lookup (parking, wifi, wheelchair access, ...).
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 120)->unique();
            $table->string('icon', 100)->nullable();
            $table->string('group', 80)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('category_field_definitions');
        Schema::dropIfExists('categories');
    }
};
