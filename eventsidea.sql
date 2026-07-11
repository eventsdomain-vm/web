-- =============================================================================
-- EventsDomain Database Schema
-- eventsidea.sql
-- =============================================================================
-- Generated from project.md specifications
-- MySQL 8.0+ | InnoDB Engine | UTF-8 (utf8mb4)
-- =============================================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS `eventsidea` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `eventsidea`;

-- =============================================================================
-- 1. USERS & AUTHENTICATION
-- =============================================================================

-- Users Table
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `mobile` VARCHAR(20) NULL DEFAULT NULL,
    `mobile_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `avatar` VARCHAR(500) NULL DEFAULT NULL,
    `phone` VARCHAR(20) NULL DEFAULT NULL,
    `provider` VARCHAR(50) NULL DEFAULT NULL,
    `provider_id` VARCHAR(255) NULL DEFAULT NULL,
    `provider_token` TEXT NULL DEFAULT NULL,
    `provider_refresh_token` TEXT NULL DEFAULT NULL,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `current_team_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `profile_photo_path` VARCHAR(2048) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_users_email` (`email`),
    KEY `idx_users_provider` (`provider`, `provider_id`),
    KEY `idx_users_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Profiles Table
CREATE TABLE `profiles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `role_type` ENUM('organizer', 'sponsor', 'partner') NOT NULL,
    `company_name` VARCHAR(255) NULL DEFAULT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `website` VARCHAR(500) NULL DEFAULT NULL,
    `social_links` JSON NULL DEFAULT NULL,
    `location` VARCHAR(255) NULL DEFAULT NULL,
    `city` VARCHAR(100) NULL DEFAULT NULL,
    `state` VARCHAR(100) NULL DEFAULT NULL,
    `country` VARCHAR(100) NULL DEFAULT NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_profiles_user_id` (`user_id`),
    KEY `idx_profiles_role_type` (`role_type`),
    CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- OTP Verifications Table
CREATE TABLE `otp_verifications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `otp_code` VARCHAR(255) NOT NULL,
    `channel` ENUM('sms', 'whatsapp', 'email') NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `attempts` INT NOT NULL DEFAULT 0,
    `verified_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_otp_user_id` (`user_id`),
    KEY `idx_otp_expires_at` (`expires_at`),
    CONSTRAINT `fk_otp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password Reset Tokens (Laravel default)
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sessions (Laravel default)
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` TEXT NULL DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_sessions_user_id` (`user_id`),
    KEY `idx_sessions_last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 2. SPATIE PERMISSION TABLES
-- =============================================================================

CREATE TABLE `roles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_roles_name_guard` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_permissions_name_guard` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    KEY `idx_rhp_role_id` (`role_id`),
    CONSTRAINT `fk_rhp_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_rhp_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
    `role_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    KEY `idx_mhr_model` (`model_type`, `model_id`),
    CONSTRAINT `fk_mhr_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    KEY `idx_mhp_model` (`model_type`, `model_id`),
    CONSTRAINT `fk_mhp_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 3. CATEGORIES
-- =============================================================================

CREATE TABLE `categories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `icon` VARCHAR(100) NULL DEFAULT NULL,
    `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_categories_slug` (`slug`),
    KEY `idx_categories_parent_id` (`parent_id`),
    KEY `idx_categories_is_active` (`is_active`),
    KEY `idx_categories_sort_order` (`sort_order`),
    CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 4. EVENTS
-- =============================================================================

CREATE TABLE `events` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `organizer_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `tagline` VARCHAR(500) NULL DEFAULT NULL,
    `description` TEXT NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `subcategory_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `event_type` ENUM('physical', 'virtual', 'hybrid') NOT NULL DEFAULT 'physical',
    `venue` VARCHAR(255) NULL DEFAULT NULL,
    `address` TEXT NULL DEFAULT NULL,
    `city` VARCHAR(100) NULL DEFAULT NULL,
    `state` VARCHAR(100) NULL DEFAULT NULL,
    `country` VARCHAR(100) NULL DEFAULT NULL,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NULL DEFAULT NULL,
    `registration_deadline` DATE NULL DEFAULT NULL,
    `expected_audience` INT UNSIGNED NULL DEFAULT NULL,
    `audience_description` TEXT NULL DEFAULT NULL,
    `budget_min` DECIMAL(15, 2) NULL DEFAULT NULL,
    `budget_max` DECIMAL(15, 2) NULL DEFAULT NULL,
    `sponsorship_type` ENUM('paid', 'barter', 'hybrid') NOT NULL DEFAULT 'paid',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 0,
    `status` ENUM('draft', 'pending', 'approved', 'rejected', 'live', 'completed', 'cancelled') NOT NULL DEFAULT 'draft',
    `rejection_reason` TEXT NULL DEFAULT NULL,
    `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `logo` VARCHAR(500) NULL DEFAULT NULL,
    `cover_image` VARCHAR(500) NULL DEFAULT NULL,
    `banner_image` VARCHAR(500) NULL DEFAULT NULL,
    `website_url` VARCHAR(500) NULL DEFAULT NULL,
    `video_url` VARCHAR(500) NULL DEFAULT NULL,
    `previous_edition_stats` JSON NULL DEFAULT NULL,
    `tags` JSON NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_events_slug` (`slug`),
    KEY `idx_events_organizer_id` (`organizer_id`),
    KEY `idx_events_category_id` (`category_id`),
    KEY `idx_events_subcategory_id` (`subcategory_id`),
    KEY `idx_events_status` (`status`),
    KEY `idx_events_city` (`city`),
    KEY `idx_events_start_date` (`start_date`),
    KEY `idx_events_is_featured` (`is_featured`),
    KEY `idx_events_created_at` (`created_at`),
    KEY `idx_events_status_featured_created` (`status`, `is_featured`, `created_at`),
    KEY `idx_events_category_city_status` (`category_id`, `city`, `status`),
    FULLTEXT KEY `ft_events_search` (`title`, `description`),
    CONSTRAINT `fk_events_organizer` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_events_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_events_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event Gallery Table
CREATE TABLE `event_gallery` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `image_url` VARCHAR(500) NOT NULL,
    `caption` VARCHAR(255) NULL DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_event_gallery_event_id` (`event_id`),
    KEY `idx_event_gallery_sort_order` (`sort_order`),
    CONSTRAINT `fk_event_gallery_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event Schedule Table
CREATE TABLE `event_schedule` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `speaker` VARCHAR(255) NULL DEFAULT NULL,
    `venue` VARCHAR(255) NULL DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_event_schedule_event_id` (`event_id`),
    KEY `idx_event_schedule_sort_order` (`sort_order`),
    CONSTRAINT `fk_event_schedule_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event Team Table
CREATE TABLE `event_team` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `role` VARCHAR(100) NOT NULL DEFAULT 'member',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_event_team_event_user` (`event_id`, `user_id`),
    KEY `idx_event_team_user_id` (`user_id`),
    CONSTRAINT `fk_event_team_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_event_team_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 5. SPONSORSHIPS
-- =============================================================================

-- Sponsorship Packages Table
CREATE TABLE `sponsorship_packages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `price` DECIMAL(15, 2) NOT NULL DEFAULT 0,
    `slots_available` INT UNSIGNED NOT NULL DEFAULT 1,
    `slots_filled` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_sponsorship_packages_event_id` (`event_id`),
    KEY `idx_sponsorship_packages_is_active` (`is_active`),
    FULLTEXT KEY `ft_sponsorship_packages_search` (`title`, `description`),
    CONSTRAINT `fk_sponsorship_packages_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sponsorship Benefits Table
CREATE TABLE `sponsorship_benefits` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `package_id` BIGINT UNSIGNED NOT NULL,
    `benefit_text` VARCHAR(500) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_sponsorship_benefits_package_id` (`package_id`),
    CONSTRAINT `fk_sponsorship_benefits_package` FOREIGN KEY (`package_id`) REFERENCES `sponsorship_packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sponsorship Requests Table
CREATE TABLE `sponsorship_requests` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `sponsor_id` BIGINT UNSIGNED NOT NULL,
    `package_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `status` ENUM('pending', 'accepted', 'rejected', 'negotiating') NOT NULL DEFAULT 'pending',
    `custom_proposal` TEXT NULL DEFAULT NULL,
    `budget_offer` DECIMAL(15, 2) NULL DEFAULT NULL,
    `message` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_sponsorship_requests_event_id` (`event_id`),
    KEY `idx_sponsorship_requests_sponsor_id` (`sponsor_id`),
    KEY `idx_sponsorship_requests_package_id` (`package_id`),
    KEY `idx_sponsorship_requests_status` (`status`),
    CONSTRAINT `fk_sponsorship_requests_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sponsorship_requests_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sponsorship_requests_package` FOREIGN KEY (`package_id`) REFERENCES `sponsorship_packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sponsorship Contracts Table
CREATE TABLE `sponsorship_contracts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `request_id` BIGINT UNSIGNED NOT NULL,
    `status` ENUM('active', 'completed', 'terminated') NOT NULL DEFAULT 'active',
    `terms` TEXT NULL DEFAULT NULL,
    `amount` DECIMAL(15, 2) NOT NULL DEFAULT 0,
    `start_date` DATE NULL DEFAULT NULL,
    `end_date` DATE NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_sponsorship_contracts_request_id` (`request_id`),
    KEY `idx_sponsorship_contracts_status` (`status`),
    CONSTRAINT `fk_sponsorship_contracts_request` FOREIGN KEY (`request_id`) REFERENCES `sponsorship_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 6. PARTNERS
-- =============================================================================

-- Partner Services Table
CREATE TABLE `partner_services` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `partner_id` BIGINT UNSIGNED NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(15, 2) NOT NULL DEFAULT 0,
    `price_type` ENUM('fixed', 'hourly', 'negotiable') NOT NULL DEFAULT 'fixed',
    `pricing_model` ENUM('cost', 'barter', 'hybrid') NOT NULL DEFAULT 'cost',
    `is_available` TINYINT(1) NOT NULL DEFAULT 1,
    `availability_calendar` JSON NULL DEFAULT NULL,
    `min_notice_days` INT UNSIGNED NOT NULL DEFAULT 7,
    `portfolio_images` JSON NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_partner_services_partner_id` (`partner_id`),
    KEY `idx_partner_services_category_id` (`category_id`),
    KEY `idx_partner_services_is_available` (`is_available`),
    FULLTEXT KEY `ft_partner_services_search` (`title`, `description`),
    CONSTRAINT `fk_partner_services_partner` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_services_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Partner Service Reviews Table
CREATE TABLE `partner_service_reviews` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `service_id` BIGINT UNSIGNED NOT NULL,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `organizer_id` BIGINT UNSIGNED NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
    `review` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_partner_reviews_service_event` (`service_id`, `event_id`),
    KEY `idx_partner_reviews_event_id` (`event_id`),
    KEY `idx_partner_reviews_organizer_id` (`organizer_id`),
    CONSTRAINT `fk_partner_reviews_service` FOREIGN KEY (`service_id`) REFERENCES `partner_services` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_reviews_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_reviews_organizer` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Partner Requests Table
CREATE TABLE `partner_requests` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `organizer_id` BIGINT UNSIGNED NOT NULL,
    `service_id` BIGINT UNSIGNED NOT NULL,
    `pricing_model` ENUM('cost', 'barter', 'hybrid') NOT NULL DEFAULT 'cost',
    `budget` DECIMAL(15, 2) NULL DEFAULT NULL,
    `message` TEXT NULL DEFAULT NULL,
    `status` ENUM('pending', 'quoted', 'accepted', 'rejected', 'completed') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_partner_requests_event_id` (`event_id`),
    KEY `idx_partner_requests_organizer_id` (`organizer_id`),
    KEY `idx_partner_requests_service_id` (`service_id`),
    KEY `idx_partner_requests_status` (`status`),
    CONSTRAINT `fk_partner_requests_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_requests_organizer` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_requests_service` FOREIGN KEY (`service_id`) REFERENCES `partner_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Partner Bids Table
CREATE TABLE `partner_bids` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `partner_id` BIGINT UNSIGNED NOT NULL,
    `service_id` BIGINT UNSIGNED NOT NULL,
    `quote_amount` DECIMAL(15, 2) NOT NULL,
    `quote_note` TEXT NULL DEFAULT NULL,
    `status` ENUM('pending', 'accepted', 'rejected', 'withdrawn') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_partner_bids_event_id` (`event_id`),
    KEY `idx_partner_bids_partner_id` (`partner_id`),
    KEY `idx_partner_bids_service_id` (`service_id`),
    KEY `idx_partner_bids_status` (`status`),
    CONSTRAINT `fk_partner_bids_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_bids_partner` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_partner_bids_service` FOREIGN KEY (`service_id`) REFERENCES `partner_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 7. SOCIAL MEDIA
-- =============================================================================

-- Social Accounts Table
CREATE TABLE `social_accounts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `provider` ENUM('linkedin', 'facebook', 'instagram', 'youtube') NOT NULL,
    `provider_id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NULL DEFAULT NULL,
    `avatar` VARCHAR(500) NULL DEFAULT NULL,
    `access_token` TEXT NOT NULL,
    `refresh_token` TEXT NULL DEFAULT NULL,
    `token_expires_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_social_accounts_provider_user` (`user_id`, `provider`, `provider_id`),
    KEY `idx_social_accounts_provider` (`provider`),
    CONSTRAINT `fk_social_accounts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event Posts Table
CREATE TABLE `event_posts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `platforms` JSON NOT NULL,
    `content` JSON NOT NULL,
    `status` ENUM('draft', 'scheduled', 'publishing', 'published', 'partial', 'failed') NOT NULL DEFAULT 'draft',
    `scheduled_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_event_posts_event_id` (`event_id`),
    KEY `idx_event_posts_user_id` (`user_id`),
    KEY `idx_event_posts_status` (`status`),
    CONSTRAINT `fk_event_posts_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_event_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Post Logs Table
CREATE TABLE `post_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_post_id` BIGINT UNSIGNED NOT NULL,
    `platform` VARCHAR(50) NOT NULL,
    `status` ENUM('success', 'failed') NOT NULL,
    `response` TEXT NULL DEFAULT NULL,
    `error_message` TEXT NULL DEFAULT NULL,
    `post_url` VARCHAR(500) NULL DEFAULT NULL,
    `published_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_post_logs_event_post_id` (`event_post_id`),
    KEY `idx_post_logs_platform` (`platform`),
    KEY `idx_post_logs_status` (`status`),
    CONSTRAINT `fk_post_logs_event_post` FOREIGN KEY (`event_post_id`) REFERENCES `event_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 8. COMMUNICATION
-- =============================================================================

-- Conversations Table
CREATE TABLE `conversations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `type` ENUM('direct', 'sponsorship', 'partnership') NOT NULL DEFAULT 'direct',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_conversations_event_id` (`event_id`),
    KEY `idx_conversations_type` (`type`),
    CONSTRAINT `fk_conversations_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Conversation Participants Table
CREATE TABLE `conversation_participants` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `conversation_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `last_read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_conv_participants_conv_user` (`conversation_id`, `user_id`),
    KEY `idx_conv_participants_user_id` (`user_id`),
    CONSTRAINT `fk_conv_participants_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_conv_participants_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Messages Table
CREATE TABLE `messages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `conversation_id` BIGINT UNSIGNED NOT NULL,
    `sender_id` BIGINT UNSIGNED NOT NULL,
    `content` TEXT NOT NULL,
    `attachment_url` VARCHAR(500) NULL DEFAULT NULL,
    `read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_messages_conversation_id` (`conversation_id`),
    KEY `idx_messages_sender_id` (`sender_id`),
    KEY `idx_messages_created_at` (`created_at`),
    CONSTRAINT `fk_messages_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notifications Table
CREATE TABLE `notifications` (
    `id` CHAR(36) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `notifiable_type` VARCHAR(255) NOT NULL,
    `notifiable_id` BIGINT UNSIGNED NOT NULL,
    `data` JSON NOT NULL,
    `read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_notifications_notifiable` (`notifiable_type`, `notifiable_id`),
    KEY `idx_notifications_read_at` (`read_at`),
    KEY `idx_notifications_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 9. SEARCH & AI
-- =============================================================================

-- Pages Table (for SEO search)
CREATE TABLE `pages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `url` VARCHAR(500) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `meta_description` TEXT NULL DEFAULT NULL,
    `score` INT UNSIGNED NOT NULL DEFAULT 0,
    `image_url` VARCHAR(500) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_pages_url` (`url`(255)),
    FULLTEXT KEY `ft_pages_search` (`title`, `content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Keywords Table
CREATE TABLE `keywords` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `keyword` VARCHAR(255) NOT NULL,
    `page_id` BIGINT UNSIGNED NOT NULL,
    `frequency` INT UNSIGNED NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_keywords_keyword` (`keyword`),
    KEY `idx_keywords_page_id` (`page_id`),
    CONSTRAINT `fk_keywords_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Backlinks Table
CREATE TABLE `backlinks` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `source_url` VARCHAR(500) NOT NULL,
    `target_url` VARCHAR(500) NOT NULL,
    `authority_score` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_backlinks_target_url` (`target_url`(255)),
    KEY `idx_backlinks_authority_score` (`authority_score`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Search Logs Table
CREATE TABLE `search_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `query` VARCHAR(500) NOT NULL,
    `result_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `duration_ms` INT UNSIGNED NOT NULL DEFAULT 0,
    `ip` VARCHAR(45) NULL DEFAULT NULL,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_search_logs_query` (`query`(255)),
    KEY `idx_search_logs_created_at` (`created_at`),
    KEY `idx_search_logs_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crawl Jobs Table
CREATE TABLE `crawl_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `url` VARCHAR(500) NOT NULL,
    `status` ENUM('pending', 'processing', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    `depth` INT UNSIGNED NOT NULL DEFAULT 0,
    `pages_crawled` INT UNSIGNED NOT NULL DEFAULT 0,
    `error` TEXT NULL DEFAULT NULL,
    `started_at` TIMESTAMP NULL DEFAULT NULL,
    `completed_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_crawl_jobs_status` (`status`),
    KEY `idx_crawl_jobs_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 10. ADMIN & SYSTEM
-- =============================================================================

-- Activity Logs Table
CREATE TABLE `activity_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `event_type` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `properties` JSON NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_activity_logs_user_id` (`user_id`),
    KEY `idx_activity_logs_event_type` (`event_type`),
    KEY `idx_activity_logs_created_at` (`created_at`),
    CONSTRAINT `fk_activity_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CMS Pages Table
CREATE TABLE `cms_pages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NOT NULL,
    `meta_title` VARCHAR(255) NULL DEFAULT NULL,
    `meta_description` TEXT NULL DEFAULT NULL,
    `is_published` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_cms_pages_slug` (`slug`),
    KEY `idx_cms_pages_is_published` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Platform Settings Table
CREATE TABLE `platform_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL,
    `value` TEXT NULL DEFAULT NULL,
    `group_name` VARCHAR(100) NOT NULL DEFAULT 'general',
    `type` ENUM('text', 'textarea', 'number', 'boolean', 'json', 'file') NOT NULL DEFAULT 'text',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_platform_settings_key` (`key`),
    KEY `idx_platform_settings_group` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache Table (Laravel)
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache Locks Table (Laravel)
CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs Table (Laravel Queue)
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_jobs_queue` (`queue`),
    KEY `idx_jobs_available_at` (`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job Batches Table (Laravel Queue)
CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL DEFAULT NULL,
    `cancelled_at` INT NULL DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Failed Jobs Table (Laravel Queue)
CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_failed_jobs_uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Personal Access Tokens (Sanctum)
CREATE TABLE `personal_access_tokens` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tokenable_type` VARCHAR(255) NOT NULL,
    `tokenable_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `token` VARCHAR(64) NOT NULL,
    `abilities` TEXT NULL DEFAULT NULL,
    `last_used_at` TIMESTAMP NULL DEFAULT NULL,
    `expires_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_pat_token` (`token`),
    KEY `idx_pat_tokenable` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 11. SEED DATA
-- =============================================================================

-- Insert Roles
INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('organizer', 'web', NOW(), NOW()),
('sponsor', 'web', NOW(), NOW()),
('partner', 'web', NOW(), NOW()),
('admin', 'web', NOW(), NOW());

-- Insert Permissions
INSERT INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
-- Event permissions
('create-events', 'web', NOW(), NOW()),
('edit-events', 'web', NOW(), NOW()),
('delete-events', 'web', NOW(), NOW()),
('publish-events', 'web', NOW(), NOW()),
('view-events', 'web', NOW(), NOW()),
-- Package permissions
('manage-packages', 'web', NOW(), NOW()),
-- Sponsorship permissions
('manage-sponsorships', 'web', NOW(), NOW()),
('view-sponsorships', 'web', NOW(), NOW()),
-- Partner permissions
('manage-services', 'web', NOW(), NOW()),
('bid-opportunities', 'web', NOW(), NOW()),
('manage-partners', 'web', NOW(), NOW()),
-- Analytics permissions
('view-analytics', 'web', NOW(), NOW()),
-- Admin permissions
('manage-users', 'web', NOW(), NOW()),
('manage-categories', 'web', NOW(), NOW()),
('manage-cms', 'web', NOW(), NOW()),
('view-reports', 'web', NOW(), NOW()),
('manage-settings', 'web', NOW(), NOW()),
('view-logs', 'web', NOW(), NOW());

-- Assign permissions to Organizer role
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT `p`.`id`, `r`.`id` FROM `permissions` `p`, `roles` `r`
WHERE `r`.`name` = 'organizer'
AND `p`.`name` IN ('create-events', 'edit-events', 'delete-events', 'publish-events', 'view-events', 'manage-packages', 'manage-sponsorships', 'view-sponsorships', 'manage-partners', 'view-analytics');

-- Assign permissions to Sponsor role
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT `p`.`id`, `r`.`id` FROM `permissions` `p`, `roles` `r`
WHERE `r`.`name` = 'sponsor'
AND `p`.`name` IN ('view-events', 'manage-sponsorships', 'view-sponsorships');

-- Assign permissions to Partner role
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT `p`.`id`, `r`.`id` FROM `permissions` `p`, `roles` `r`
WHERE `r`.`name` = 'partner'
AND `p`.`name` IN ('manage-services', 'bid-opportunities', 'view-events');

-- Assign ALL permissions to Admin role
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT `p`.`id`, `r`.`id` FROM `permissions` `p`, `roles` `r`
WHERE `r`.`name` = 'admin';

-- Insert Default Categories (3-Tier Taxonomy)
INSERT INTO `categories` (`name`, `slug`, `icon`, `parent_id`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
-- Business (parent)
('Business', 'business', 'briefcase', NULL, 1, 1, NOW(), NOW()),
('Conferences', 'conferences', NULL, 1, 1, 1, NOW(), NOW()),
('Seminars', 'seminars', NULL, 1, 2, 1, NOW(), NOW()),
('Workshops', 'workshops', NULL, 1, 3, 1, NOW(), NOW()),
('Trade Shows', 'trade-shows', NULL, 1, 4, 1, NOW(), NOW()),
('Exhibitions', 'exhibitions', NULL, 1, 5, 1, NOW(), NOW()),
('Product Launches', 'product-launches', NULL, 1, 6, 1, NOW(), NOW()),
('Networking Events', 'networking-events', NULL, 1, 7, 1, NOW(), NOW()),
('Business Summits', 'business-summits', NULL, 1, 8, 1, NOW(), NOW()),
('Corporate Meetings', 'corporate-meetings', NULL, 1, 9, 1, NOW(), NOW()),
('Awards & Recognition', 'awards-recognition', NULL, 1, 10, 1, NOW(), NOW()),
('Investor Events', 'investor-events', NULL, 1, 11, 1, NOW(), NOW()),

-- Entertainment (parent)
('Entertainment', 'entertainment', 'musical-note', NULL, 2, 1, NOW(), NOW()),
('Music Concerts', 'music-concerts', NULL, 13, 1, 1, NOW(), NOW()),
('Live Shows', 'live-shows', NULL, 13, 2, 1, NOW(), NOW()),
('Comedy Shows', 'comedy-shows', NULL, 13, 3, 1, NOW(), NOW()),
('Theatre & Drama', 'theatre-drama', NULL, 13, 4, 1, NOW(), NOW()),
('Fashion Shows', 'fashion-shows', NULL, 13, 5, 1, NOW(), NOW()),
('Film Screenings', 'film-screenings', NULL, 13, 6, 1, NOW(), NOW()),
('Nightlife', 'nightlife', NULL, 13, 7, 1, NOW(), NOW()),
('Esports & Gaming', 'esports-gaming', NULL, 13, 8, 1, NOW(), NOW()),
('Sports Events', 'sports-events', NULL, 13, 9, 1, NOW(), NOW()),
('Fitness & Wellness', 'fitness-wellness', NULL, 13, 10, 1, NOW(), NOW()),
('Adventure Activities', 'adventure-activities', NULL, 13, 11, 1, NOW(), NOW()),

-- Festivals & Community (parent)
('Festivals & Community', 'festivals-community', 'users', NULL, 3, 1, NOW(), NOW()),
('Music Festivals', 'music-festivals', NULL, 25, 1, 1, NOW(), NOW()),
('Food Festivals', 'food-festivals', NULL, 25, 2, 1, NOW(), NOW()),
('Cultural Festivals', 'cultural-festivals', NULL, 25, 3, 1, NOW(), NOW()),
('Religious Festivals', 'religious-festivals', NULL, 25, 4, 1, NOW(), NOW()),
('Literature Festivals', 'literature-festivals', NULL, 25, 5, 1, NOW(), NOW()),
('Art Festivals', 'art-festivals', NULL, 25, 6, 1, NOW(), NOW()),
('Film Festivals', 'film-festivals', NULL, 25, 7, 1, NOW(), NOW()),
('Shopping Festivals', 'shopping-festivals', NULL, 25, 8, 1, NOW(), NOW()),
('Government Events', 'government-events', NULL, 25, 9, 1, NOW(), NOW()),
('Charity & Fundraising', 'charity-fundraising', NULL, 25, 10, 1, NOW(), NOW()),
('Awareness Campaigns', 'awareness-campaigns', NULL, 25, 11, 1, NOW(), NOW()),
('Career Fairs', 'career-fairs', NULL, 25, 12, 1, NOW(), NOW()),
('Educational Events', 'educational-events', NULL, 25, 13, 1, NOW(), NOW()),
('Science & Technology Events', 'science-technology-events', NULL, 25, 14, 1, NOW(), NOW()),
('Book Fairs', 'book-fairs', NULL, 25, 15, 1, NOW(), NOW()),
('Community Events', 'community-events', NULL, 25, 16, 1, NOW(), NOW());

-- Insert Default Admin User (password: password)
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `is_verified`, `created_at`, `updated_at`) VALUES
('Admin', 'admin@eventsdomain.com', NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), NOW());

-- Assign Admin role to admin user
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
SELECT `r`.`id`, 'App\\Models\\User', `u`.`id` FROM `roles` `r`, `users` `u`
WHERE `r`.`name` = 'admin' AND `u`.`email` = 'admin@eventsdomain.com';

-- Insert Platform Settings
INSERT INTO `platform_settings` (`key`, `value`, `group_name`, `type`, `created_at`, `updated_at`) VALUES
('site_name', 'EventsDomain', 'general', 'text', NOW(), NOW()),
('site_description', 'Connect Events with Brands, Sponsors & Partners', 'general', 'textarea', NOW(), NOW()),
('site_email', 'eventsdomain.com@gmail.com', 'general', 'text', NOW(), NOW()),
('site_phone', '+91 9725098250', 'general', 'text', NOW(), NOW()),
('site_url', 'https://eventsdomain.com', 'general', 'text', NOW(), NOW()),
('analytics_enabled', 'false', 'analytics', 'boolean', NOW(), NOW()),
('analytics_id', '', 'analytics', 'text', NOW(), NOW()),
('smtp_host', '', 'mail', 'text', NOW(), NOW()),
('smtp_port', '587', 'mail', 'number', NOW(), NOW()),
('smtp_username', '', 'mail', 'text', NOW(), NOW()),
('smtp_password', '', 'mail', 'text', NOW(), NOW()),
('registration_enabled', 'true', 'auth', 'boolean', NOW(), NOW()),
('email_verification_required', 'true', 'auth', 'boolean', NOW(), NOW()),
('otp_enabled', 'true', 'auth', 'boolean', NOW(), NOW());

-- =============================================================================
-- END OF SCHEMA
-- =============================================================================
