<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Sirve archivos del disco public sin depender del symlink web del SO.
     */
    public function show(Request $request, string $path): StreamedResponse
    {
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');
        $path = str_replace('..', '', $path);

        if ($path === '' || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path);
    }
}
