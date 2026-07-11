<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSchemaController extends Controller
{
    public function index(): View
    {
        $schemas = [
            'organization' => $this->getOrganizationSchema(),
            'website' => $this->getWebsiteSchema(),
            'breadcrumb' => $this->getBreadcrumbSchema(),
            'faq' => $this->getFaqSchema(),
            'event' => $this->getEventSchema(),
            'sponsor' => $this->getSponsorSchema(),
            'review' => $this->getReviewSchema(),
            'person' => $this->getPersonSchema(),
            'article' => $this->getArticleSchema(),
            'service' => $this->getServiceSchema(),
            'collection' => $this->getCollectionSchema(),
        ];

        return view('admin.seo.schema', compact('schemas'));
    }

    public function check(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schema_type' => 'required|string',
            'schema_data' => 'required|array',
        ]);

        $schema = $this->getSchemaByType($validated['schema_type']);

        if ($schema) {
            $isValid = $this->validateSchema($schema, $validated['schema_data']);

            if ($isValid) {
                return redirect()->back()->with('success', 'Schema validation passed!');
            } else {
                return redirect()->back()->withErrors(['schema' => 'Schema validation failed.']);
            }
        }

        return redirect()->back()->withErrors(['schema' => 'Schema type not supported.']);
    }

    private function getOrganizationSchema()
    {
        return [
            'type' => 'Organization',
            'name' => 'Events Domain',
            'url' => url('/'),
            'logo' => url('/logo.png'),
            'description' => 'Where Great Events Meet the Right Sponsors',
            'sameAs' => [
                'https://facebook.com/eventsdomain',
                'https://linkedin.com/company/eventsdomain',
            ],
        ];
    }

    private function getWebsiteSchema()
    {
        return [
            'type' => 'WebSite',
            'name' => 'Events Domain',
            'url' => url('/'),
            'potentialAction' => [
                'type' => 'SearchAction',
                'target' => url('/search?q={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private function getBreadcrumbSchema()
    {
        return [
            'type' => 'BreadcrumbList',
            'itemListElement' => [
                ['position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['position' => 2, 'name' => 'Events', 'item' => url('/events')],
                ['position' => 3, 'name' => 'Technology Events', 'item' => url('/events/category/technology')],
            ],
        ];
    }

    private function getFaqSchema()
    {
        return [
            'type' => 'FAQPage',
            'mainEntity' => [
                [
                    'type' => 'Question',
                    'name' => 'What is event sponsorship?',
                    'acceptedAnswer' => 'This is a placeholder for FAQ content.',
                ],
                [
                    'type' => 'Question',
                    'name' => 'How do sponsors choose events?',
                    'acceptedAnswer' => 'This is a placeholder for FAQ content.',
                ],
            ],
        ];
    }

    private function getEventSchema()
    {
        return [
            'type' => 'Event',
            'name' => 'Sample Event',
            'startDate' => '2026-07-15',
            'endDate' => '2026-07-17',
            'location' => [
                'type' => 'Place',
                'name' => 'New York, NY',
                'address' => [
                    'streetAddress' => '123 Event Street',
                    'addressLocality' => 'New York',
                    'addressRegion' => 'NY',
                    'postalCode' => '10001',
                    'addressCountry' => 'US',
                ],
            ],
            'url' => url('/events/sample-event'),
            'image' => url('/storage/events/sample-event/banner.jpg'),
            'description' => 'This is a sample event description.',
            'offers' => [
                'type' => 'EventReservation',
                'price' => '100.00',
                'priceCurrency' => 'USD',
            ],
        ];
    }

    private function getSponsorSchema()
    {
        return [
            'type' => 'Organization',
            'name' => 'Sample Sponsor',
            'url' => url('/sponsors/sample-sponsor'),
            'logo' => url('/storage/sponsors/sample-sponsor/logo.png'),
            'description' => 'This is a sample sponsor description.',
            'review' => [
                'type' => 'Review',
                'ratingValue' => '4.5',
                'reviewCount' => '12',
                'bestRating' => '5',
            ],
        ];
    }

    private function getReviewSchema()
    {
        return [
            'type' => 'Review',
            'name' => 'Sample Review',
            'reviewRating' => [
                'type' => 'Rating',
                'ratingValue' => '4.5',
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'author' => [
                'type' => 'Person',
                'name' => 'John Doe',
            ],
            'reviewBody' => 'This is a sample review body.',
            'datePublished' => '2026-06-01',
        ];
    }

    private function getPersonSchema()
    {
        return [
            'type' => 'Person',
            'name' => 'John Doe',
            'url' => url('/team/john-doe'),
            'image' => url('/storage/team/john-doe/avatar.jpg'),
            'jobTitle' => 'Event Organizer',
            'description' => 'John is an experienced event organizer.',
        ];
    }

    private function getArticleSchema()
    {
        return [
            'type' => 'Article',
            'headline' => 'Sample Blog Post',
            'url' => url('/blog/sample-post'),
            'datePublished' => '2026-06-01T10:00:00+00:00',
            'dateModified' => '2026-06-01T10:00:00+00:00',
            'image' => url('/storage/blog/sample-post/feature.jpg'),
            'author' => [
                'type' => 'Person',
                'name' => 'John Doe',
            ],
            'publisher' => [
                'type' => 'Organization',
                'name' => 'Events Domain',
                'logo' => url('/logo.png'),
            ],
            'description' => 'This is a sample blog post description.',
        ];
    }

    private function getServiceSchema()
    {
        return [
            'type' => 'Service',
            'name' => 'Event Sponsorship Platform',
            'url' => url('/'),
            'description' => 'Professional event sponsorship platform for connecting events with sponsors.',
            'provider' => [
                'type' => 'Organization',
                'name' => 'Events Domain',
            ],
        ];
    }

    private function getCollectionSchema()
    {
        return [
            'type' => 'Collection',
            'name' => 'Event Collection',
            'url' => url('/events'),
            'description' => 'A collection of events.',
        ];
    }

    private function getSchemaByType($type)
    {
        $schemas = [
            'organization' => $this->getOrganizationSchema(),
            'website' => $this->getWebsiteSchema(),
            'breadcrumb' => $this->getBreadcrumbSchema(),
            'faq' => $this->getFaqSchema(),
            'event' => $this->getEventSchema(),
            'sponsor' => $this->getSponsorSchema(),
            'review' => $this->getReviewSchema(),
            'person' => $this->getPersonSchema(),
            'article' => $this->getArticleSchema(),
            'service' => $this->getServiceSchema(),
            'collection' => $this->getCollectionSchema(),
        ];

        return $schemas[$type] ?? null;
    }

    private function validateSchema($schema, $data): bool
    {
        // Simple validation - in production, use a proper JSON schema validator
        $requiredFields = ['type', 'name'];

        foreach ($requiredFields as $field) {
            if (! isset($data[$field]) || empty($data[$field])) {
                return false;
            }
        }

        return true;
    }
}
