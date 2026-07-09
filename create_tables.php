<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();

// Create sponsor_objectives table
$pdo->exec("
CREATE TABLE IF NOT EXISTS `sponsor_objectives` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sponsor_id` bigint unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text NULL,
    `objective_type` enum('brand_awareness','lead_generation','sales_conversion','csr','product_launch','market_entry','other') NOT NULL DEFAULT 'brand_awareness',
    `target_kpi_value` decimal(15,2) NULL,
    `kpi_unit` varchar(255) NULL,
    `estimated_cost` decimal(15,2) NULL,
    `estimated_roi` decimal(15,2) NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `sort_order` int NOT NULL DEFAULT 0,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    INDEX `idx_sponsor_objectives_sponsor_id` (`sponsor_id`),
    INDEX `idx_sponsor_objectives_type` (`objective_type`),
    CONSTRAINT `sponsor_objectives_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

echo "Created sponsor_objectives table\n";

// Create sponsor_preferences table
$pdo->exec("
CREATE TABLE IF NOT EXISTS `sponsor_preferences` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sponsor_id` bigint unsigned NOT NULL,
    `target_audience_demographics` json NULL,
    `category_preferences` json NULL,
    `event_types` json NULL,
    `geographic_preferences` json NULL,
    `budget_range` json NULL,
    `formats_preferred` enum('title','presenting','booth','digital','virtual','sponsorship_rights') NULL,
    `industry_targets` json NULL,
    `min_audience_size` int NULL,
    `max_audience_size` int NULL,
    `notes` text NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    UNIQUE KEY `uk_sponsor_preferences_sponsor_id` (`sponsor_id`),
    CONSTRAINT `sponsor_preferences_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

echo "Created sponsor_preferences table\n";

// Create sponsor_budget_allocations table
$pdo->exec("
CREATE TABLE IF NOT EXISTS `sponsor_budget_allocations` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sponsor_id` bigint unsigned NOT NULL,
    `fiscal_year` varchar(255) NOT NULL,
    `category_allocations` json NULL,
    `total_budget` decimal(15,2) NOT NULL,
    `allocated_so_far` decimal(15,2) NOT NULL DEFAULT 0,
    `status` enum('draft','approved','active','closed') NOT NULL DEFAULT 'draft',
    `valid_from` timestamp NULL,
    `valid_to` timestamp NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    UNIQUE KEY `uk_budget_allocations_year` (`sponsor_id`, `fiscal_year`),
    INDEX `idx_budget_allocations_status` (`sponsor_id`, `status`),
    CONSTRAINT `sponsor_budget_allocations_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

echo "Created sponsor_budget_allocations table\n";
echo "All tables created successfully!\n";