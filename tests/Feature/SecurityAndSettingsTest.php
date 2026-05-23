<?php

namespace Tests\Feature;

use App\Models\PortalSetting;
use App\Models\User;
use App\Services\PortalSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_taxes_online_pay_is_blocked(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->post('/fr/taxes/pay', [
            'payment_ids' => [1],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('payment');
    }

    public function test_clave_requires_valid_password(): void
    {
        $user = User::factory()->create([
            'nie' => '12345678a',
            'is_active' => true,
            'password' => Hash::make('SecretPass1'),
        ]);

        $this->post('/fr/clave/conectar', [
            'nie' => '12345678A',
            'password' => 'wrong',
            'intent' => 'login',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();

        $this->post('/fr/clave/conectar', [
            'nie' => '12345678A',
            'password' => 'SecretPass1',
            'intent' => 'login',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_store_whatsapp_number(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.settings.update'), [
                'gestoria_whatsapp' => '34 612 345 678',
            ])
            ->assertRedirect(route('admin.settings.index'));

        $this->assertSame('34612345678', app(PortalSettingsService::class)->whatsappNumber());
        $this->assertSame('34612345678', PortalSetting::getValue('gestoria_whatsapp'));
    }
}
