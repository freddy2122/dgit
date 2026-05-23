<?php

namespace App\Services;

use App\Models\PortalPayment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminTaxService
{
    public function __construct(
        private PortalNotificationService $notifications,
        private PermitTramiteService $tramites,
    ) {}

    /** @return array<string, array{label: string, amount: float, reference_prefix: string}> */
    public function presets(): array
    {
        return config('dgt_taxes.presets', []);
    }

    /**
     * @param  array{
     *     tax_preset?: string|null,
     *     label?: string|null,
     *     amount?: float|string|null,
     *     due_date?: string|null,
     *     permit_application_id?: int|null,
     *     status?: string|null
     * }  $data
     */
    public function assign(User $user, array $data): PortalPayment
    {
        abort_unless($user->role === 'user', 404);

        [$label, $amount, $kind, $prefix] = $this->resolveTaxFields($data);

        $dueDate = ! empty($data['due_date'])
            ? \Illuminate\Support\Carbon::parse($data['due_date'])->startOfDay()
            : now()->addDays(14)->startOfDay();

        $status = in_array($data['status'] ?? 'awaiting_whatsapp', ['pending', 'awaiting_whatsapp'], true)
            ? ($data['status'] ?? 'awaiting_whatsapp')
            : 'awaiting_whatsapp';

        $payment = PortalPayment::query()->create([
            'user_id' => $user->id,
            'permit_application_id' => $data['permit_application_id'] ?? null,
            'payment_kind' => $kind,
            'label' => $label,
            'amount' => round($amount, 2),
            'due_date' => $dueDate,
            'status' => $status,
            'reference' => $this->newReference($prefix),
        ]);

        $this->notifications->notify($user, 'admin.notif_tax_assigned_title', 'admin.notif_tax_assigned_body', [
            'label' => $label,
            'amount' => number_format($amount, 2, ',', ' '),
            'ref' => $payment->reference,
            'due' => $dueDate->format('d/m/Y'),
        ]);

        return $payment;
    }

    public function confirmReceived(PortalPayment $payment): PortalPayment
    {
        if (! in_array($payment->status, ['pending', 'awaiting_whatsapp'], true)) {
            throw ValidationException::withMessages([
                'payment' => __('admin.tax_already_settled'),
            ]);
        }

        $this->tramites->confirmPayment($payment);

        if ($payment->user) {
            $this->notifications->notify($payment->user, 'admin.notif_tax_paid_title', 'admin.notif_tax_paid_body', [
                'label' => $payment->label,
                'ref' => $payment->reference,
            ]);
        }

        return $payment->fresh();
    }

    public function cancel(PortalPayment $payment): void
    {
        if ($payment->status === 'paid') {
            throw ValidationException::withMessages([
                'payment' => __('admin.tax_cannot_cancel_paid'),
            ]);
        }

        $payment->delete();
    }

    /** @return array{0: string, 1: float, 2: string, 3: string} */
    private function resolveTaxFields(array $data): array
    {
        $presetKey = $data['tax_preset'] ?? null;
        $presets = $this->presets();

        if ($presetKey && $presetKey !== 'custom' && isset($presets[$presetKey])) {
            $preset = $presets[$presetKey];
            $amount = isset($data['amount']) && $data['amount'] !== '' && $data['amount'] !== null
                ? (float) $data['amount']
                : (float) $preset['amount'];

            return [
                $preset['label'],
                $amount,
                $presetKey,
                $preset['reference_prefix'] ?? 'TAS',
            ];
        }

        $label = trim((string) ($data['label'] ?? ''));
        $amount = (float) ($data['amount'] ?? 0);

        if ($label === '' || $amount <= 0) {
            throw ValidationException::withMessages([
                'tax' => __('admin.tax_assign_invalid'),
            ]);
        }

        return [$label, $amount, 'custom', 'CUS'];
    }

    private function newReference(string $prefix): string
    {
        return 'TAS-'.strtoupper($prefix).'-'.strtoupper(Str::random(5));
    }
}
