<?php

namespace Tests\Unit\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Organization;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    private InvoiceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(InvoiceService::class);
    }

    public function test_can_create_invoice(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);

        $data = [
            'client_id' => $organization->clients()->create([
                'name' => 'Test Client',
                'email' => 'test@example.com',
            ])->id,
            'project_id' => null,
            'issue_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'notes' => 'Test invoice',
            'items' => [
                [
                    'description' => 'Test item',
                    'qty' => 1,
                    'unit_price' => 100,
                    'vat_rate' => 21,
                ],
            ],
        ];

        $invoice = $this->service->create($organization->id, $data);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertNotNull($invoice->number);
        $this->assertEquals($organization->id, $invoice->organization_id);
        $this->assertEquals('draft', $invoice->status);
        $this->assertEquals(100, $invoice->subtotal);
        $this->assertEquals(21, $invoice->vat_total);
        $this->assertEquals(121, $invoice->total);
    }

    public function test_can_update_invoice(): void
    {
        $organization = Organization::factory()->create();
        $client = $organization->clients()->create([
            'name' => 'Test Client',
            'email' => 'test@example.com',
        ]);

        $invoice = Invoice::factory()->create([
            'organization_id' => $organization->id,
            'client_id' => $client->id,
        ]);

        InvoiceItem::factory()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Old item',
            'qty' => 1,
            'unit_price' => 50,
            'vat_rate' => 21,
        ]);

        $data = [
            'client_id' => $client->id,
            'project_id' => null,
            'issue_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'notes' => 'Updated invoice',
            'items' => [
                [
                    'description' => 'Updated item',
                    'qty' => 2,
                    'unit_price' => 150,
                    'vat_rate' => 21,
                ],
            ],
        ];

        $updatedInvoice = $this->service->update($invoice, $data);

        $this->assertEquals(300, $updatedInvoice->subtotal);
        $this->assertEquals(63, $updatedInvoice->vat_total);
        $this->assertEquals(363, $updatedInvoice->total);
        $this->assertEquals('Updated invoice', $updatedInvoice->notes);
    }

    public function test_generates_sequential_invoice_number(): void
    {
        $organization = Organization::factory()->create();
        $year = now()->year;

        $invoice1 = $this->service->generateInvoiceNumber($organization->id);
        $this->assertStringStartsWith("INV-{$year}-", $invoice1);
        $this->assertEquals("INV-{$year}-001", $invoice1);

        // Create a real invoice to increment the counter
        $client = $organization->clients()->create(['name' => 'Test']);
        $invoice = Invoice::factory()->create([
            'organization_id' => $organization->id,
            'client_id' => $client->id,
            'number' => $invoice1,
        ]);

        $invoice2 = $this->service->generateInvoiceNumber($organization->id);
        $this->assertEquals("INV-{$year}-002", $invoice2);
    }
}

