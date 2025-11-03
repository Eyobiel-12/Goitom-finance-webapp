<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@goitom-finance.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create a sample organization for testing
        $organization = \App\Models\Organization::create([
            'owner_user_id' => $admin->id,
            'name' => 'Goitom Finance BV',
            'slug' => 'goitom-finance',
            'vat_number' => 'NL123456789B01',
            'country' => 'NL',
            'currency' => 'EUR',
            'default_vat_rate' => 21.00,
            'branding_color' => '#d4af37',
            'status' => 'active',
        ]);

        // Create a sample ondernemer user
        $ondernemer = User::create([
            'organization_id' => $organization->id,
            'name' => 'Test Ondernemer',
            'email' => 'ondernemer@example.com',
            'password' => Hash::make('password'),
            'role' => 'ondernemer',
            'email_verified_at' => now(),
        ]);

        // Create some sample data
        $this->createSampleData($organization);
    }

    private function createSampleData(\App\Models\Organization $organization): void
    {
        // Create sample clients
        $clients = [
            [
                'name' => 'Acme Corporation',
                'contact_name' => 'John Doe',
                'email' => 'john@acme.com',
                'phone' => '+31 6 12345678',
                'address' => [
                    'street' => 'Hoofdstraat 123',
                    'city' => 'Amsterdam',
                    'postal_code' => '1000 AB',
                    'country' => 'NL',
                ],
                'tax_id' => 'NL987654321B01',
            ],
            [
                'name' => 'Tech Solutions BV',
                'contact_name' => 'Jane Smith',
                'email' => 'jane@techsolutions.nl',
                'phone' => '+31 6 87654321',
                'address' => [
                    'street' => 'Innovatieweg 456',
                    'city' => 'Rotterdam',
                    'postal_code' => '3000 CD',
                    'country' => 'NL',
                ],
            ],
        ];

        foreach ($clients as $clientData) {
            $organization->clients()->create($clientData);
        }

        // Create sample projects
        $projects = [
            [
                'client_id' => $organization->clients()->first()->id,
                'name' => 'Website Development',
                'description' => 'Complete website development project',
                'status' => 'active',
                'rate' => 75.00,
                'hours' => 40.00,
            ],
            [
                'client_id' => $organization->clients()->skip(1)->first()->id,
                'name' => 'Mobile App',
                'description' => 'iOS and Android mobile application',
                'status' => 'active',
                'rate' => 85.00,
                'hours' => 60.00,
            ],
        ];

        foreach ($projects as $projectData) {
            $organization->projects()->create($projectData);
        }

        // Create sample invoices
        $invoices = [
            [
                'client_id' => $organization->clients()->first()->id,
                'project_id' => $organization->projects()->first()->id,
                'number' => 'INV-2024-001',
                'issue_date' => now()->subDays(30),
                'due_date' => now()->subDays(15),
                'subtotal' => 3000.00,
                'vat_total' => 630.00,
                'total' => 3630.00,
                'status' => 'paid',
                'sent_at' => now()->subDays(30),
            ],
            [
                'client_id' => $organization->clients()->skip(1)->first()->id,
                'project_id' => $organization->projects()->skip(1)->first()->id,
                'number' => 'INV-2024-002',
                'issue_date' => now()->subDays(15),
                'due_date' => now()->addDays(15),
                'subtotal' => 5100.00,
                'vat_total' => 1071.00,
                'total' => 6171.00,
                'status' => 'sent',
                'sent_at' => now()->subDays(15),
            ],
        ];

        foreach ($invoices as $invoiceData) {
            $invoice = $organization->invoices()->create($invoiceData);
            
            // Create invoice items
            $invoice->items()->create([
                'description' => 'Development work',
                'qty' => 1,
                'unit_price' => $invoice->subtotal,
                'vat_rate' => 21.00,
                'net_amount' => $invoice->subtotal,
                'vat_amount' => $invoice->vat_total,
                'line_total' => $invoice->total,
            ]);
        }
    }
}
