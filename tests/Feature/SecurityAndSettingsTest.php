<?php

namespace Tests\Feature;

use App\Mail\PasswordResetCodeMail;
use App\Models\PortalSetting;
use App\Models\User;
use App\Services\PortalSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function test_user_can_reset_password_with_email_code(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'client@example.com',
            'is_active' => true,
            'password' => Hash::make('AncienPass123'),
        ]);

        $this->post('/fr/password/forgot', [
            'email' => 'client@example.com',
        ])->assertRedirect('/fr/password/reset?email=client%40example.com')
            ->assertSessionHas('status', __('auth.reset_code_sent'));

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'client@example.com',
        ]);

        $plainCode = null;

        Mail::assertSent(PasswordResetCodeMail::class, function (PasswordResetCodeMail $mail) use (&$plainCode, $user) {
            $plainCode = $mail->plainCode;

            return $mail->hasTo($user->email);
        });

        $this->assertNotNull($plainCode);

        $this->post('/fr/password/reset', [
            'email' => 'client@example.com',
            'code' => $plainCode,
            'password' => 'NouveauPass123',
            'password_confirmation' => 'NouveauPass123',
        ])->assertRedirect('/fr/login')
            ->assertSessionHas('status', __('auth.reset_success'));

        $this->assertTrue(Hash::check('NouveauPass123', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'client@example.com',
        ]);
    }

    public function test_admin_can_update_client_password_from_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
            'password' => Hash::make('AncienPass123'),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.users.update_password', $client), [
                'password' => 'NouveauPass456',
                'password_confirmation' => 'NouveauPass456',
            ])
            ->assertRedirect(route('admin.users.show', $client))
            ->assertSessionHas('status', __('admin.password_updated'));

        $this->assertTrue(Hash::check('NouveauPass456', $client->fresh()->password));
    }

    public function test_user_can_update_own_password_from_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
            'password' => Hash::make('AncienPass123'),
        ]);

        $this->actingAs($user)
            ->post('/fr/dashboard/profil/password', [
                'current_password' => 'AncienPass123',
                'password' => 'NouveauPass789',
                'password_confirmation' => 'NouveauPass789',
            ])
            ->assertRedirect()
            ->assertSessionHas('portal_success', __('portal.profile.password_updated'));

        $this->assertTrue(Hash::check('NouveauPass789', $user->fresh()->password));
    }
}
