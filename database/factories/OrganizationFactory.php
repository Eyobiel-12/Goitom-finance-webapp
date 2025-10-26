<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'owner_user_id' => \App\Models\User::factory(),
            'name' => fake()->company() . ' BV',
            'slug' => fake()->slug(),
            'tagline' => fake()->sentence(),
            'vat_number' => fake()->numerify('NL#########B##'),
            'country' => 'NL',
            'currency' => 'EUR',
            'default_vat_rate' => 21.00,
            'logo_path' => null,
            'branding_color' => '#10b981',
            'settings' => null,
            'status' => 'active',
        ];
    }
}
