<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalPayment;
use App\Models\User;
use App\Services\AdminTaxService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    public function __construct(private AdminTaxService $taxes)
    {
    }

    public function index(Request $request): View
    {
        $query = PortalPayment::query()
            ->with(['user', 'permitApplication'])
            ->latest('created_at');

        if ($userId = $request->query('user')) {
            $query->where('user_id', $userId);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        return view('admin.payments.index', [
            'payments' => tap($query->paginate(30), fn ($p) => $p->appends($request->query())),
            'clients' => User::query()->where('role', 'user')->orderBy('name')->get(['id', 'name', 'nie', 'email']),
            'presets' => $this->taxes->presets(),
            'filterUser' => $request->query('user') ? User::query()->find($request->query('user')) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'tax_preset' => ['required', 'string', 'max:64'],
            'label' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0.01', 'max:99999'],
            'due_date' => ['nullable', 'date'],
            'permit_application_id' => ['nullable', 'exists:permit_applications,id'],
        ]);

        $user = User::query()->findOrFail($validated['user_id']);
        abort_unless($user->role === 'user', 404);

        $this->taxes->assign($user, $validated);

        $redirect = $request->input('redirect') === 'payments'
            ? route('admin.payments.index', ['user' => $user->id])
            : route('admin.users.show', $user);

        return redirect($redirect)->with('status', __('admin.tax_assigned'));
    }

    public function confirm(PortalPayment $payment): RedirectResponse
    {
        $this->taxes->confirmReceived($payment);

        return back()->with('status', __('admin.tax_confirmed'));
    }

    public function destroy(PortalPayment $payment): RedirectResponse
    {
        $this->taxes->cancel($payment);

        return back()->with('status', __('admin.tax_removed'));
    }
}
