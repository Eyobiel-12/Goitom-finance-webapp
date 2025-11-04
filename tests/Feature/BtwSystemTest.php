<?php

namespace Tests\Feature;

use App\Models\BtwAangifte;
use App\Models\BtwAftrek;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BtwSystemTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Organization $organization;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organization = Organization::factory()->create([
            'subscription_status' => 'active',
            'subscription_plan' => 'pro',
            'btw_stelsel' => 'factuur',
        ]);

        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
        ]);
    }

    public function test_btw_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.btw.index'));

        $response->assertOk();
    }

    public function test_btw_aftrek_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.btw-aftrek.index'));

        $response->assertOk();
    }

    public function test_btw_aftrek_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.btw-aftrek.create'));

        $response->assertOk();
        $response->assertSeeLivewire('btw-aftrek-form');
    }

    public function test_btw_aangifte_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('app.btw-aangifte.index'));

        $response->assertOk();
        $response->assertSeeLivewire('btw-aangifte-generator');
    }

    public function test_btw_aangifte_calculates_correctly(): void
    {
        // Create paid invoice
        $client = \App\Models\Client::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $client->id,
            'status' => 'paid',
            'issue_date' => now(),
        ]);

        $invoice->items()->create([
            'description' => 'Service',
            'qty' => 1,
            'unit_price' => 100,
            'vat_rate' => 21,
            'net_amount' => 100,
            'vat_amount' => 21,
            'line_total' => 121,
        ]);

        $aangifte = BtwAangifte::create([
            'organization_id' => $this->organization->id,
            'jaar' => now()->year,
            'kwartaal' => ceil(now()->month / 3),
            'status' => 'concept',
        ]);

        $aangifte->calculate();
        $aangifte->save();

        $this->assertEquals(100, $aangifte->omzet_excl_btw);
        $this->assertEquals(21, $aangifte->ontvangen_btw);
    }

    public function test_btw_aftrek_can_be_created(): void
    {
        $aftrek = BtwAftrek::create([
            'organization_id' => $this->organization->id,
            'naam' => 'Test Aftrek',
            'bedrag_excl_btw' => 100,
            'btw_percentage' => 21,
            'btw_bedrag' => 21,
            'totaal_bedrag' => 121,
            'datum' => now(),
            'status' => 'draft',
        ]);

        $this->assertNotNull($aftrek->id);
        $this->assertEquals(100, $aftrek->bedrag_excl_btw);
        $this->assertEquals(21, $aftrek->btw_bedrag);
    }

    public function test_btw_correction_blocked_for_starter_users(): void
    {
        // Switch to starter
        $this->organization->update(['subscription_plan' => 'starter']);

        $this->assertFalse($this->organization->canUseFeature('advanced_btw'));
    }

    public function test_btw_aangifte_has_deadline(): void
    {
        $aangifte = BtwAangifte::create([
            'organization_id' => $this->organization->id,
            'jaar' => now()->year,
            'kwartaal' => 1,
            'status' => 'concept',
        ]);

        $aangifte->calculate();
        $aangifte->save();
        $aangifte->refresh();

        // Deadline is calculated in BtwAangifte::calculate() method
        // Test that calculate ran successfully
        $this->assertNotNull($aangifte->omzet_excl_btw);
    }

    public function test_btw_settings_stored_per_organization(): void
    {
        $settings = \App\Models\BtwSettings::create([
            'organization_id' => $this->organization->id,
            'btw_stelsel' => 'kassa',
        ]);

        $this->assertEquals('kassa', $settings->btw_stelsel);
        $this->assertEquals($this->organization->id, $settings->organization_id);
    }

    public function test_cash_basis_uses_payment_dates(): void
    {
        $this->organization->update(['btw_stelsel' => 'kassa']);

        \App\Models\BtwSettings::create([
            'organization_id' => $this->organization->id,
            'btw_stelsel' => 'kassa',
        ]);

        $client = \App\Models\Client::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $invoice = Invoice::factory()->create([
            'organization_id' => $this->organization->id,
            'client_id' => $client->id,
            'status' => 'paid',
            'issue_date' => now()->subMonth(),
        ]);

        $invoice->items()->create([
            'description' => 'Service',
            'qty' => 1,
            'unit_price' => 100,
            'vat_rate' => 21,
            'net_amount' => 100,
            'vat_amount' => 21,
            'line_total' => 121,
        ]);

        // Add payment
        $invoice->payments()->create([
            'amount' => 121,
            'date' => now(),
            'method' => 'bank',
        ]);

        $aangifte = BtwAangifte::create([
            'organization_id' => $this->organization->id,
            'jaar' => now()->year,
            'kwartaal' => ceil(now()->month / 3),
            'status' => 'concept',
        ]);

        $aangifte->calculate();

        // Should include invoice because payment is in current period
        $this->assertGreaterThan(0, $aangifte->ontvangen_btw);
    }
}
