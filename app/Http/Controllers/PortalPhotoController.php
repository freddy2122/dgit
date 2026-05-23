<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PortalPhotoController extends Controller
{
    public function __construct(private \App\Services\UserDocumentService $documents)
    {
        $this->middleware('auth');
    }

    /** Photo affichée sur la carte permis (photo dédiée ou recto DNI). */
    public function show(): BinaryFileResponse|Response
    {
        $user = auth()->user();
        $path = $this->documents->cardPhotoPath($user);
        abort_unless($path, 404);

        return response()->file($this->documents->absolutePath($path));
    }

    /** Signature manuscrite pour le permis numérique. */
    public function signature(): BinaryFileResponse|Response
    {
        return $this->serve(auth()->user(), 'signature');
    }

    public function document(string $locale, string $type): BinaryFileResponse|Response
    {
        abort_unless(in_array($type, \App\Services\UserDocumentService::TYPES, true), 404);

        return $this->serve(auth()->user(), $type);
    }

    private function serve(\App\Models\User $user, string $type): BinaryFileResponse|Response
    {
        $absolute = $this->documents->absolutePath($this->documents->pathFor($user, $type));
        abort_unless($absolute, 404);

        return response()->file($absolute);
    }
}
