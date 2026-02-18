<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $logoDataUrl = null;
        $signatureDataUrl = null;
        if ($user->logo_path && Storage::disk('local')->exists($user->logo_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($user->logo_path));
            $logoDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($user->logo_path));
        }
        if ($user->signature_path && Storage::disk('local')->exists($user->signature_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($user->signature_path));
            $signatureDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($user->signature_path));
        }
        return view('profile.edit', compact('user', 'logoDataUrl', 'signatureDataUrl'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'signature' => ['nullable', 'image', 'max:1024'],
        ]);

        $dir = "users/{$user->id}/profile";

        if ($request->hasFile('logo')) {
            Storage::disk('local')->delete($user->logo_path);
            $path = $request->file('logo')->store($dir, 'local');
            $user->update(['logo_path' => $path]);
        }
        if ($request->hasFile('signature')) {
            Storage::disk('local')->delete($user->signature_path);
            $path = $request->file('signature')->store($dir, 'local');
            $user->update(['signature_path' => $path]);
        }

        return redirect()->route('profile.edit')->with('success', __('Perfil atualizado.'));
    }
}
