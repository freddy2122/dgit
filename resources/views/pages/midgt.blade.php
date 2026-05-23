@extends('layouts.app')

@section('title', 'MiDGT — Identification')

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-600" aria-label="Fil d’Ariane">
                <a href="{{ route('home') }}" class="font-medium text-[#004481] hover:underline">Accueil</a>
                <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
                <span class="text-gray-900">MiDGT</span>
            </nav>
        </div>
    </div>

    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
        <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-10">
            @include('sede.partials.identificacion-sede', ['context' => 'midgt'])
        </article>

        <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <a
                href="{{ sede_href('es/permisos-de-conducir') }}"
                class="rounded-lg border border-gray-200 bg-white p-4 text-sm font-semibold text-[#004481] shadow-sm transition hover:border-[#004481]/30"
            >
                Permis de conduire →
            </a>
            <a
                href="{{ sede_href('es/vehiculos') }}"
                class="rounded-lg border border-gray-200 bg-white p-4 text-sm font-semibold text-[#004481] shadow-sm transition hover:border-[#004481]/30"
            >
                Véhicules →
            </a>
        </div>
    </div>
@endsection
