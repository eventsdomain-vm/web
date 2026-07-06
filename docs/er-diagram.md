# Events Domain — ER Diagram

```mermaid
erDiagram
    %% ============================================
    %% GROUP: Users & Authentication
    %% ============================================
    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string mobile
        timestamp mobile_verified_at
        boolean is_verified
        string avatar
        string phone
        string provider
        string provider_id
        text provider_token
        text provider_refresh_token
        timestamp remember_token
        timestamp created_at
        timestamp updated_at
    }

    profiles {
        bigint id PK
        bigint user_id FK
        enum role_type "organizer|sponsor|partner"
        string company_name
        text description
        string website
        json social_links
        string location
        string city
        string state
        string country
        boolean is_verified
        timestamp created_at
        timestamp updated_at
    }

    otp_verifications {
        bigint id PK
        bigint user_id FK
        string otp_code
        enum channel "sms|whatsapp|email"
        timestamp expires_at
        integer attempts
        timestamp verified_at
        timestamp created_at
        timestamp updated_at
    }

    social_accounts {
        bigint id PK
        bigint user_id FK
        enum provider "linkedin|facebook|instagram|youtube"
        string provider_id
        string name
        string email
        string avatar
        text access_token
        text refresh_token
        timestamp token_expires_at
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Taxonomy & Lookup
    %% ============================================
    categories {
        bigint id PK
        uuid uuid
        string name
        string slug UK
        text description
        string icon
        bigint parent_id FK
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    category_field_definitions {
        bigint id PK
        bigint category_id FK
        string section_key
        string field_key
        string label
        enum input_type "text|textarea|number|date|time|select|multiselect|boolean|repeater|media"
        boolean is_visible
        boolean is_required
        json options
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    amenities {
        bigint id PK
        string name
        string slug UK
        string icon
        string group
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Events Core
    %% ============================================
    events {
        bigint id PK
        uuid uuid
        bigint organizer_id FK "→ users"
        bigint category_id FK "→ categories"
        bigint subcategory_id FK "→ categories"
        string title
        string slug UK
        string tagline
        text description
        enum event_type "physical|virtual|hybrid"
        enum visibility "public|unlisted|private"
        enum approval_status "draft|pending|approved|rejected|changes_requested"
        enum status "draft|pending|approved|rejected|live|completed|cancelled"
        text rejection_reason
        string timezone
        char currency
        decimal budget_min
        decimal budget_max
        decimal minimum_sponsorship
        decimal maximum_sponsorship
        enum sponsorship_type "paid|barter|hybrid"
        unsigned_int expected_audience
        text audience_description
        date registration_deadline
        string registration_url
        string website_url
        string video_url
        string logo
        string cover_image
        string banner_image
        json previous_edition_stats
        json tags
        boolean is_featured
        boolean is_published
        timestamp published_at
        unsigned_int views_count
        datetime start_date "denormalized"
        datetime end_date "denormalized"
        datetime next_occurrence_at "denormalized"
        string venue "denormalized"
        string city "denormalized"
        string state "denormalized"
        string country "denormalized"
        decimal primary_latitude "denormalized"
        decimal primary_longitude "denormalized"
        timestamp deleted_at
        timestamp created_at
        timestamp updated_at
    }

    event_statistics {
        bigint id PK
        bigint event_id FK "unique"
        unsigned_int views
        unsigned_int unique_views
        unsigned_int saves
        unsigned_int shares
        unsigned_int sponsor_requests_count
        unsigned_int enquiries_count
        unsigned_int packages_count
        timestamp last_viewed_at
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Event Scheduling
    %% ============================================
    event_dates {
        bigint id PK
        bigint event_id FK
        string label
        date start_date
        date end_date
        time start_time
        time end_time
        string timezone
        boolean all_day
        integer sort_order
        string recurrence_rule "RFC 5545"
        date recurrence_until
        timestamp created_at
        timestamp updated_at
    }

    event_venues {
        bigint id PK
        bigint event_id FK
        enum venue_type "physical|virtual|hybrid"
        string venue_name
        string address
        string city
        string state
        string country
        string postal_code
        decimal latitude
        decimal longitude
        string virtual_url
        string virtual_platform
        boolean is_primary
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    event_stages {
        bigint id PK
        bigint event_id FK
        bigint event_venue_id FK
        string name
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    event_schedule {
        bigint id PK
        bigint event_id FK
        bigint event_date_id FK
        bigint stage_id FK
        string title
        text description
        time start_time
        time end_time
        string speaker "fallback"
        string venue
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Participants
    %% ============================================
    participant_types {
        bigint id PK
        string name
        string slug UK
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    participants {
        bigint id PK
        uuid uuid
        string name
        string slug UK
        string type
        text bio
        string image
        string website
        json social_links
        string organization
        string designation
        string company
        timestamp deleted_at
        timestamp created_at
        timestamp updated_at
    }

    event_participants {
        bigint id PK
        bigint event_id FK
        bigint participant_id FK
        bigint participant_type_id FK
        bigint event_date_id FK
        string role_label
        string session_title
        datetime performance_start
        datetime performance_end
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Event Content
    %% ============================================
    event_gallery {
        bigint id PK
        bigint event_id FK
        bigint media_id FK
        string image_url
        string caption
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    event_documents {
        bigint id PK
        bigint event_id FK
        string title
        string file_path
        string file_type
        unsigned_int file_size
        enum visibility "public|sponsors_only|private"
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    event_faqs {
        bigint id PK
        bigint event_id FK
        string question
        text answer
        boolean is_published
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    event_amenities {
        bigint id PK
        bigint event_id FK
        bigint amenity_id FK
        string notes
        timestamp created_at
        timestamp updated_at
    }

    event_team {
        bigint id PK
        bigint event_id FK
        bigint user_id FK
        string role
        timestamp created_at
        timestamp updated_at
    }

    ticket_types {
        bigint id PK
        bigint event_id FK
        string name
        text description
        decimal price
        char currency
        unsigned_int quantity_total
        unsigned_int quantity_sold
        datetime sales_start
        datetime sales_end
        boolean is_active
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    organizer_contacts {
        bigint id PK
        bigint event_id FK
        bigint user_id FK
        string name
        string designation
        string email
        string phone
        string whatsapp
        boolean is_primary
        boolean is_public
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    social_links {
        bigint id PK
        bigint linkable_id
        string linkable_type
        string platform
        string url
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Sponsorship
    %% ============================================
    sponsors {
        bigint id PK
        uuid uuid
        bigint user_id FK
        string name
        string slug UK
        string logo
        string website
        string industry
        text description
        json social_links
        boolean is_verified
        timestamp deleted_at
        timestamp created_at
        timestamp updated_at
    }

    sponsor_packages {
        bigint id PK
        bigint event_id FK
        string title
        string level
        text description
        decimal price
        char currency
        string budget_range_label
        unsigned_int slots_available
        unsigned_int slots_filled
        boolean is_active
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    sponsorship_benefits {
        bigint id PK
        bigint package_id FK
        string benefit_text
        timestamp created_at
        timestamp updated_at
    }

    sponsorship_opportunities {
        bigint id PK
        uuid uuid
        bigint event_id FK
        bigint sponsor_package_id FK
        string title
        enum type "advertising_space|food_partnership|content_addon|naming_rights|booth|other"
        text description
        decimal price
        char currency
        enum availability "available|limited|sold_out"
        unsigned_int slots_total
        unsigned_int slots_filled
        json metadata
        integer sort_order
        timestamp deleted_at
        timestamp created_at
        timestamp updated_at
    }

    sponsorship_requests {
        bigint id PK
        bigint event_id FK
        bigint sponsor_id FK "→ users"
        bigint package_id FK
        enum status "pending|accepted|rejected|negotiating"
        text custom_proposal
        decimal budget_offer
        text message
        timestamp created_at
        timestamp updated_at
    }

    sponsorship_contracts {
        bigint id PK
        bigint request_id FK
        enum status "active|completed|terminated"
        text terms
        decimal amount
        date start_date
        date end_date
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Partner Marketplace
    %% ============================================
    partner_services {
        bigint id PK
        bigint partner_id FK "→ users"
        bigint category_id FK
        string title
        text description
        decimal price
        enum price_type "fixed|hourly|negotiable"
        enum pricing_model "cost|barter|hybrid"
        boolean is_available
        json availability_calendar
        unsigned_int min_notice_days
        json portfolio_images
        timestamp created_at
        timestamp updated_at
    }

    partner_service_reviews {
        bigint id PK
        bigint service_id FK
        bigint event_id FK
        bigint organizer_id FK "→ users"
        unsigned_tinyint rating
        text review
        timestamp created_at
        timestamp updated_at
    }

    partner_requests {
        bigint id PK
        bigint event_id FK
        bigint organizer_id FK "→ users"
        bigint service_id FK
        enum pricing_model "cost|barter|hybrid"
        decimal budget
        text message
        enum status "pending|quoted|accepted|rejected|completed"
        timestamp created_at
        timestamp updated_at
    }

    partner_bids {
        bigint id PK
        bigint event_id FK
        bigint partner_id FK "→ users"
        bigint service_id FK
        decimal quote_amount
        text quote_note
        enum status "pending|accepted|rejected|withdrawn"
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Communication
    %% ============================================
    conversations {
        bigint id PK
        bigint event_id FK
        enum type "direct|sponsorship|partnership"
        timestamp created_at
        timestamp updated_at
    }

    conversation_participants {
        bigint id PK
        bigint conversation_id FK
        bigint user_id FK
        timestamp last_read_at
        timestamp created_at
        timestamp updated_at
    }

    messages {
        bigint id PK
        bigint conversation_id FK
        bigint sender_id FK "→ users"
        text content
        string attachment_url
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }

    notifications {
        uuid id PK
        string type
        bigint notifiable_id
        string notifiable_type
        json data
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }

    event_posts {
        bigint id PK
        bigint event_id FK
        bigint user_id FK
        json platforms
        json content
        enum status "draft|scheduled|publishing|published|partial|failed"
        timestamp scheduled_at
        timestamp created_at
        timestamp updated_at
    }

    post_logs {
        bigint id PK
        bigint event_post_id FK
        string platform
        enum status "success|failed"
        text response
        text error_message
        string post_url
        timestamp published_at
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: Media (Spatie)
    %% ============================================
    media {
        bigint id PK
        bigint model_id
        string model_type
        uuid uuid
        string collection_name
        string name
        string file_name
        string mime_type
        string disk
        string conversions_disk
        bigint size
        json manipulations
        json custom_properties
        json generated_conversions
        json responsive_images
        unsigned_int order_column
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% GROUP: SEO & CMS
    %% ============================================
    cms_pages {
        bigint id PK
        string title
        string slug UK
        longtext content
        string meta_title
        string meta_description
        boolean is_published
        timestamp created_at
        timestamp updated_at
    }

    pages {
        bigint id PK
        string title
        string slug UK
        longtext content
        string meta_title
        string meta_description
        boolean is_published
        timestamp created_at
        timestamp updated_at
    }

    keywords {
        bigint id PK
        string keyword
        string category
        enum competition_level "low|medium|high"
        unsigned_int monthly_search_volume
        unsigned_tinyint difficulty_score
        enum intent "informational|transactional|navigational|commercial"
        timestamp created_at
        timestamp updated_at
    }

    search_logs {
        bigint id PK
        string query
        bigint user_id FK
        string ip_address
        unsigned_int results_count
        timestamp created_at
        timestamp updated_at
    }

    crawl_jobs {
        bigint id PK
        string target_url
        enum status "pending|running|completed|failed"
        unsigned_smallint response_code
        string page_title
        text meta_description
        json headers_found
        json links_found
        json errors
        timestamp created_at
        timestamp updated_at
    }

    backlinks {
        bigint id PK
        string target_url
        string source_url
        string anchor_text
        unsigned_tinyint domain_authority
        enum link_type "dofollow|nofollow|sponsored|ugc"
        enum status "active|broken|pending"
        timestamp created_at
        timestamp updated_at
    }

    %% ============================================
    %% RELATIONSHIPS
    %% ============================================

    %% Users & Profiles
    users ||--o{ profiles : "has"
    users ||--o{ otp_verifications : "has"
    users ||--o{ social_accounts : "has"

    %% Categories (self-referencing)
    categories ||--o{ categories : "parent_id"
    categories ||--o{ category_field_definitions : "defines fields"

    %% Events → Taxonomy
    users ||--o{ events : "organizes"
    categories ||--o{ events : "categorizes"
    categories ||--o{ events : "subcategory"

    %% Events → Scheduling
    events ||--o{ event_dates : "has dates"
    events ||--o{ event_venues : "has venues"
    events ||--o{ event_stages : "has stages"
    events ||--o{ event_schedule : "has sessions"
    event_venues ||--o{ event_stages : "hosts"
    event_dates ||--o{ event_schedule : "slots into"
    event_stages ||--o{ event_schedule : "hosts on"

    %% Events → Participants
    participants ||--o{ event_participants : "participates"
    participant_types ||--o{ event_participants : "typed as"
    events ||--o{ event_participants : "has participants"
    event_dates ||--o{ event_participants : "scheduled on"

    %% Events → Content
    events ||--o{ event_gallery : "has gallery"
    media ||--o{ event_gallery : "attached as"
    events ||--o{ event_documents : "has docs"
    events ||--o{ event_faqs : "has FAQs"
    events ||--o{ event_amenities : "offers"
    amenities ||--o{ event_amenities : "available as"
    events ||--o{ event_team : "team members"
    users ||--o{ event_team : "on team"
    events ||--o{ ticket_types : "ticketed"
    events ||--o{ organizer_contacts : "contacts"
    users ||--o{ organizer_contacts : "contact person"
    events ||--o{ event_statistics : "stats"

    %% Events → Sponsorship
    events ||--o{ sponsor_packages : "offers packages"
    sponsor_packages ||--o{ sponsorship_benefits : "includes"
    events ||--o{ sponsorship_opportunities : "opportunities"
    sponsor_packages ||--o{ sponsorship_opportunities : "linked to"
    events ||--o{ sponsorship_requests : "receives"
    users ||--o{ sponsorship_requests : "sends"
    sponsor_packages ||--o{ sponsorship_requests : "targets"
    sponsorship_requests ||--o{ sponsorship_contracts : "results in"

    %% Sponsors
    users ||--o{ sponsors : "owns sponsor profile"
    sponsors ||--o{ sponsorship_requests : "submits"

    %% Partner Marketplace
    users ||--o{ partner_services : "offers service"
    categories ||--o{ partner_services : "categorized under"
    partner_services ||--o{ partner_service_reviews : "reviewed via"
    events ||--o{ partner_service_reviews : "reviewed for"
    partner_services ||--o{ partner_requests : "requested via"
    events ||--o{ partner_requests : "requests"
    partner_services ||--o{ partner_bids : "bid on"
    events ||--o{ partner_bids : "receives bids"

    %% Communication
    events ||--o{ conversations : "context for"
    conversations ||--o{ conversation_participants : "includes"
    users ||--o{ conversation_participants : "participates in"
    conversations ||--o{ messages : "contains"
    users ||--o{ messages : "sends"
    users ||--o{ notifications : "receives"
    events ||--o{ event_posts : "posted for"
    users ||--o{ event_posts : "creates"
    event_posts ||--o{ post_logs : "logged via"

    %% SEO
    users ||--o{ search_logs : "searches"
```
