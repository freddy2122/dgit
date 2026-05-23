@extends('layouts.app')

@section('title', ($page['title_fr'] ?? $page['title']).' — Permis')

@section('content')
    @php
        $sedePath = $page['path'] ?? '';
        redirect()->to(sede_href($sedePath))->send();
    @endphp
@endsection
