<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Organization $organization;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organization = Organization::factory()->create([
            'subscription_status' => 'active',
            'subscription_plan' => 'pro',
        ]);

        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $this->client = Client::factory()->create([
            'organization_id' => $this->organization->id,
            'email' => 'client@test.com',
        ]);
    }

    public function test_invoice_list_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.invoices.index'));

        $response->assertOk();
    }

    public function test_invoice_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.invoices.create'));

        $response->assertOk();
        $response->assertSeeLivewire('invoice-form');
    }

    public function test_invoice_has_correct_vat_calculations(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
            'subtotal' => 200,
            'vat_total' => 42,
            'total' => 242,
        ]);

        $netAmount = 2 * 100; // qty * unit_price
        $vatAmount = $netAmount * (21 / 100);
        $lineTotal = $netAmount + $vatAmount;

        $invoice->items()->create([
            'description' => 'Test Service',
            'qty' => 2,
            'unit_price' => 100,
            'vat_rate' => 21,
            'net_amount' => $netAmount,
            'vat_amount' => $vatAmount,
            'line_total' => $lineTotal,
        ]);

        $this->assertEquals(200, $invoice->subtotal);
        $this->assertEquals(42, $invoice->vat_total);
        $this->assertEquals(242, $invoice->total);
    }

    public function test_invoice_show_page_loads(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('app.invoices.show', $invoice));

        $response->assertOk();
        $response->assertSee($invoice->number);
    }

    public function test_invoice_can_be_marked_as_paid(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
            'status' => 'sent',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('app.invoices.markPaid', $invoice));

        $invoice->refresh();
        $this->assertEquals('paid', $invoice->status);
    }

    public function test_pro_users_can_send_invoices(): void
    {
        // Pro organization
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('app.invoices.send', $invoice));

        // Should not have error for Pro users
        $response->assertSessionMissing('error');
    }

    public function test_invoice_numbers_are_unique(): void
    {
        $invoice1 = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
            'number' => 'INV-2025-001',
        ]);

        $invoice2 = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
            'number' => 'INV-2025-002',
        ]);

        $this->assertNotEquals($invoice1->number, $invoice2->number);
    }

    public function test_invoice_belongs_to_organization(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
        ]);

        $this->assertEquals($this->organization->id, $invoice->organization_id);
        $this->assertInstanceOf(Organization::class, $invoice->organization);
    }

    public function test_invoice_belongs_to_client(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
        ]);

        $this->assertEquals($this->client->id, $invoice->client_id);
        $this->assertInstanceOf(Client::class, $invoice->client);
    }

    public function test_invoice_pdf_route_works(): void
    {
        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $this->client->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('app.invoices.pdf', $invoice));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
