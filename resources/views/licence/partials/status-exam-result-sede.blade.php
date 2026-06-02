@php
    $exam = $exam ?? ($payload['exam'] ?? []);
    $passed = (bool) ($exam['passed'] ?? false);
@endphp

@if (! empty($exam['show']))
<div id="resultado-examen" class="mt-6 scroll-mt-8">
    <div class="sede-exam mx-auto w-full max-w-[420px]">
        <header class="sede-exam__header">
            <div class="sede-exam__logos">
                <img src="{{ asset('images/logo_dgt.svg') }}" alt="DGT" width="80" height="28" />
                <div>
                    <p class="sede-exam__gov">{{ __('status.exam_sede_gov') }}</p>
                    <p class="sede-exam__gov">{{ __('status.exam_sede_ministry') }}</p>
                </div>
            </div>
            <p class="sede-exam__sede-label">{{ __('status.exam_sede_office') }}</p>
            <p class="sede-exam__sede-url">sede.dgt.gob.es</p>
        </header>

        <div class="sede-exam__title-wrap">
            <h2 class="sede-exam__title">{{ __('status.exam_sede_title') }}</h2>
        </div>

        <dl class="sede-exam__panel">
            @foreach ([
                'exam_sede_name' => $exam['holder'] ?? '—',
                'exam_sede_nie' => $exam['nie'] ?? '—',
                'exam_sede_class' => $exam['license_class'] ?? 'B',
                'exam_sede_test_type' => __('status.exam_test_theory'),
                'exam_sede_date' => $exam['date'] ?? '—',
                'exam_sede_grade' => $passed ? __('status.exam_grade_pass') : __('status.exam_grade_fail'),
                'exam_sede_errors' => (string) ($exam['errors'] ?? '—'),
            ] as $labelKey => $value)
                <div class="sede-exam__row">
                    <dt class="sede-exam__label">{{ __('status.'.$labelKey) }}</dt>
                    <dd class="sede-exam__value {{ $labelKey === 'exam_sede_grade' ? ($passed ? 'sede-exam__value--apto' : 'sede-exam__value--fail') : '' }}">
                        {{ $value }}
                    </dd>
                </div>
            @endforeach
        </dl>

        <p class="sede-exam__disclaimer">{{ __('status.exam_sede_disclaimer') }}</p>

        <div class="sede-exam__aviso">
            <strong>{{ __('status.exam_sede_aviso_title') }}</strong>
            {{ __('status.exam_sede_notice') }}
        </div>

        <a href="{{ portal_licence_status_href(['view' => 'result']) }}" class="sede-exam__back">
            {{ __('status.exam_sede_back') }}
        </a>
    </div>
</div>

@once
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/status-midgt-pixel.css') }}?v=1" />
    @endpush
@endonce
@endif
