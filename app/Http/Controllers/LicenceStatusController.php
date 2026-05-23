<?php

namespace App\Http\Controllers;

use App\Models\PermitApplication;
use App\Models\User;
use App\Services\PermitStatusSearchService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LicenceStatusController extends Controller
{
    public function __construct(private PermitStatusSearchService $statusSearch)
    {
    }

    public function create(Request $request): View|RedirectResponse
    {
        if ($request->boolean('reset')) {
            $request->session()->forget([
                'permit_search_result_id',
                'permit_search_user_id',
                'permit_search_searched',
                'permit_search_payload',
            ]);

            return redirect()->to(portal_route('licence.status'));
        }

        $userId = $request->session()->get('permit_search_user_id');
        $user = $userId
            ? User::query()->with(['licenseSummary', 'vehicles', 'permitApplications'])->find($userId)
            : null;

        $application = null;
        if ($user) {
            $application = $user->permitApplications()->latest('id')->first()
                ?? ($request->session()->get('permit_search_result_id')
                    ? PermitApplication::query()->with('user')->find($request->session()->get('permit_search_result_id'))
                    : null);
        }

        $searched = (bool) $request->session()->get('permit_search_searched', false);
        $payload = $request->session()->get('permit_search_payload', []);
        $activeTab = $request->query('view') === 'result' && $searched ? 'result' : 'search';

        $photoSrc = $user && $searched && ($payload['found'] ?? false)
            ? portal_route('licence.status.photo')
            : null;

        return view('licence.status', [
            'user' => $user,
            'application' => $application,
            'searched' => $searched,
            'payload' => $payload,
            'photoSrc' => $photoSrc,
            'authCode' => auth()->user()?->verification_code,
            'activeTab' => $activeTab,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'birth_day' => $this->nullableIntInput($request->input('birth_day')),
            'birth_month' => $this->nullableIntInput($request->input('birth_month')),
            'birth_year' => $this->nullableIntInput($request->input('birth_year')),
        ]);

        $validated = $request->validate([
            'verification_code' => ['nullable', 'string', 'max:20'],
            'nie' => ['nullable', 'string', 'max:14'],
            'birth_day' => ['nullable', 'integer', 'between:1,31'],
            'birth_month' => ['nullable', 'integer', 'between:1,12'],
            'birth_year' => ['nullable', 'integer', 'min:1920', 'max:'.(int) date('Y')],
        ]);

        $code = trim((string) ($validated['verification_code'] ?? ''));
        $hasIdentity = ! empty($validated['nie'])
            && $validated['birth_day'] !== null
            && $validated['birth_month'] !== null
            && $validated['birth_year'] !== null;

        if ($code === '' && ! $hasIdentity) {
            throw ValidationException::withMessages([
                'verification_code' => __('status.search_required'),
            ]);
        }

        if ($hasIdentity) {
            $request->validate([
                'nie' => ['required', 'string', 'max:14'],
                'birth_day' => ['required', 'integer', 'between:1,31'],
                'birth_month' => ['required', 'integer', 'between:1,12'],
                'birth_year' => ['required', 'integer', 'min:1920', 'max:'.(int) date('Y')],
            ]);

            try {
                Carbon::createFromDate(
                    $validated['birth_year'],
                    $validated['birth_month'],
                    $validated['birth_day'],
                    config('app.timezone')
                )->startOfDay();
            } catch (\Throwable) {
                throw ValidationException::withMessages([
                    'birth_day' => __('status.invalid_date'),
                ]);
            }
        }

        $resolved = $this->statusSearch->resolve($validated);
        $payload = $this->statusSearch->toPayload($resolved);
        $user = $resolved['user']?->fresh(['licenseSummary', 'vehicles']);
        $application = $resolved['application'];

        $request->session()->put('permit_search_searched', true);
        $request->session()->put('permit_search_payload', $payload);
        $request->session()->put('permit_search_result_id', $application?->id);

        if ($user) {
            $request->session()->put('permit_search_user_id', $user->id);
        } else {
            $request->session()->forget('permit_search_user_id');
        }

        return redirect()
            ->to(portal_route('licence.status', ['view' => 'result']))
            ->with('status_search_done', true);
    }

    /** Photo DNI pour la consultation publique (session de recherche récente). */
    public function photo(Request $request): BinaryFileResponse|Response
    {
        $userId = $request->session()->get('permit_search_user_id');
        abort_unless($userId, 403);

        $user = User::query()->findOrFail($userId);
        $documents = app(\App\Services\UserDocumentService::class);
        $path = $documents->cardPhotoPath($user);
        abort_unless($path, 404);

        return response()->file($documents->absolutePath($path));
    }

    private function nullableIntInput(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value) && (int) $value == $value) {
            return (int) $value;
        }

        return null;
    }
}
