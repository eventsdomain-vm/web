<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    // Realistic brand-style company name pool so it doesn't look like random Faker gibberish
    protected $companyPrefixes = [
        'Zynta', 'Bluewave', 'Nimbus', 'Orbex', 'Vertex', 'Craftly', 'Solace',
        'Northline', 'Pixelforge', 'Everstack', 'Redcloak', 'Sunveda', 'Kinetic',
        'Havenly', 'Brightloop', 'Corewell', 'Trueform', 'Nextfin', 'Vantaro', 'Loomex',
    ];
    protected $companySuffixes = ['Technologies', 'Beverages', 'Foods', 'Sportswear', 'Media', 'Finserv', 'Retail', 'Mobility', 'Wellness', 'Labs'];

    protected $indianCities = [
        'Mumbai', 'Delhi', 'Bengaluru', 'Hyderabad', 'Chennai', 'Pune',
        'Kolkata', 'Ahmedabad', 'Jaipur', 'Chandigarh',
    ];

    public function definition(): array
    {
        $name = $this->faker->randomElement($this->companyPrefixes) . ' ' . $this->faker->randomElement($this->companySuffixes);
        $slug = str()->slug($name);

        return [
            'user_id' => null, // attach via ->for(User::factory()) or set in seeder if you need login accounts
            'company_name' => $name,
            'logo_path' => null, // seed with a placeholder path if you have sample images, else leave null
            'website' => "https://{$slug}.com",

            'contact_person' => $this->faker->name(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_phone' => '9' . $this->faker->numerify('#########'), // Indian-style 10-digit mobile

            'city' => $this->faker->randomElement($this->indianCities),
            'country' => 'India',

            'budget_range' => $this->faker->randomElement([
                'under_50k', '50k_1l', '1l_5l', '5l_25l', '25l_plus',
            ]),

            'preferred_sponsorship_type' => $this->faker->randomElement(['cash', 'barter', 'paid_barter']),

            'about' => $this->faker->paragraph(2),

            'status' => $this->faker->randomElement(['active', 'active', 'active', 'pending_verification', 'inactive']),
            // weighted so most seeded partners are usable ("active") by default
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => 'active']);
    }
}
