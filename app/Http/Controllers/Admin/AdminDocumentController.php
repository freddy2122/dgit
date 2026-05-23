<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminDocumentController extends Controller
{
    public function index(): View
    {
        return view('admin.documents.index', [
            'users' => User::query()
                ->where('role', 'user')
                ->where(function ($q) {
                    $q->whereNotNull('license_photo_path')
                        ->orWhereNotNull('dni_recto_path')
                        ->orWhereNotNull('dni_verso_path')
                        ->orWhereNotNull('signature_path');
                })
                ->latest('updated_at')
                ->paginate(20),
        ]);
    }
}
