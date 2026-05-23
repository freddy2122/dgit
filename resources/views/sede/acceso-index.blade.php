@extends('layouts.app')

@section('title', __('sede.acceso.title'))

@section('content')
    @include('sede.partials.layout', [
        'navPath' => 'es/acceso',
        'breadcrumbs' => [
            ['label' => __('sede.acceso.login'), 'path' => null],
        ],
    ])

    <article class="min-w-0 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-10">
        @include('sede.partials.identificacion-sede', ['context' => 'sede'])
    </article>

    @include('sede.partials.layout-end')
@endsection
