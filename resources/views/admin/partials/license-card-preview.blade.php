@php
    $user = $user ?? null;
    $license = $license ?? $user?->licenseSummary;
@endphp

@if ($user && $license)
    <div class="mb-4 inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm" role="tablist">
        <button type="button" data-admin-license-tab="front" class="admin-license-tab rounded-md bg-[#004481] px-4 py-2 text-sm font-semibold text-white" aria-selected="true">
            {{ __('portal.license.front') }}
        </button>
        <button type="button" data-admin-license-tab="back" class="admin-license-tab rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50" aria-selected="false">
            {{ __('portal.license.back') }}
        </button>
    </div>

    <div id="admin-license-front" class="flex flex-col items-center py-2">
        @include('portal.partials.license-card-maquette', ['user' => $user, 'license' => $license, 'size' => 'display'])
    </div>
    <div id="admin-license-back" class="hidden flex-col items-center py-2">
        @include('portal.partials.license-card-back', ['user' => $user, 'license' => $license, 'size' => 'display'])
    </div>

    @once
        @push('scripts')
            <script>
                document.querySelectorAll('[data-admin-license-tab]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const tab = btn.dataset.adminLicenseTab;
                        const front = document.getElementById('admin-license-front');
                        const back = document.getElementById('admin-license-back');
                        front?.classList.toggle('hidden', tab !== 'front');
                        front?.classList.toggle('flex', tab === 'front');
                        back?.classList.toggle('hidden', tab !== 'back');
                        back?.classList.toggle('flex', tab === 'back');
                        document.querySelectorAll('[data-admin-license-tab]').forEach((b) => {
                            const active = b.dataset.adminLicenseTab === tab;
                            b.classList.toggle('bg-[#004481]', active);
                            b.classList.toggle('text-white', active);
                            b.classList.toggle('text-gray-700', !active);
                            b.setAttribute('aria-selected', active ? 'true' : 'false');
                        });
                    });
                });
            </script>
        @endpush
    @endonce
@else
    <p class="rounded-lg border border-dashed border-gray-200 bg-slate-50 px-6 py-10 text-center text-sm text-gray-600">—</p>
@endif
