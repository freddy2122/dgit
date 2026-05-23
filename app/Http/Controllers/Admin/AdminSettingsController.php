<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PortalSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    public function __construct(private PortalSettingsService $settings)
    {
    }

    public function index(): View
    {
        return view('admin.settings.index', [
            'whatsappNumber' => $this->settings->whatsappNumber(),
            'envWhatsapp' => (string) config('gestoria.whatsapp_number', ''),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gestoria_whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s\-]{8,20}$/'],
        ]);

        $this->settings->updateWhatsappNumber($validated['gestoria_whatsapp']);

        return redirect()
            ->route('admin.settings.index')
            ->with('admin_success', __('admin.settings_saved'));
    }
}
