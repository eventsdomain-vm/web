-- Run this in phpMyAdmin or MySQL CLI against the events_idea database

ALTER TABLE organizer_profiles
    ADD COLUMN pincode VARCHAR(20) NULL AFTER country,
    ADD COLUMN pan_no VARCHAR(20) NULL AFTER tax_id,
    ADD COLUMN designation VARCHAR(100) NULL AFTER business_type,
    ADD COLUMN gst_number VARCHAR(20) NULL AFTER pan_no,
    ADD COLUMN gst_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER gst_number,
    ADD COLUMN gst_legal_name VARCHAR(255) NULL AFTER gst_verified,
    ADD COLUMN gst_verified_at TIMESTAMP NULL AFTER gst_legal_name,
    ADD COLUMN pan_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER gst_verified_at,
    ADD COLUMN pan_verified_at TIMESTAMP NULL AFTER pan_verified,
    ADD COLUMN official_email VARCHAR(255) NULL AFTER website,
    ADD COLUMN social_media_link VARCHAR(500) NULL AFTER official_email,
    ADD COLUMN client_references JSON NULL AFTER social_media_link;

ALTER TABLE partner_profiles
    ADD COLUMN pincode VARCHAR(20) NULL AFTER country,
    ADD COLUMN pan_no VARCHAR(20) NULL AFTER tax_id,
    ADD COLUMN designation VARCHAR(100) NULL AFTER business_type,
    ADD COLUMN gst_number VARCHAR(20) NULL AFTER pan_no,
    ADD COLUMN gst_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER gst_number,
    ADD COLUMN gst_legal_name VARCHAR(255) NULL AFTER gst_verified,
    ADD COLUMN gst_verified_at TIMESTAMP NULL AFTER gst_legal_name,
    ADD COLUMN pan_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER gst_verified_at,
    ADD COLUMN pan_verified_at TIMESTAMP NULL AFTER pan_verified,
    ADD COLUMN official_email VARCHAR(255) NULL AFTER website,
    ADD COLUMN social_media_link VARCHAR(500) NULL AFTER official_email,
    ADD COLUMN client_references JSON NULL AFTER social_media_link;
