<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilePhotoController extends Controller
{
    public function edit(): View
    {
        return view('profile-photo');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'photo.required' => 'Kies eerst een foto.',
            'photo.image'    => 'Het bestand moet een afbeelding zijn.',
            'photo.mimes'    => 'Gebruik een JPG, PNG of WEBP bestand.',
            'photo.max'      => 'De foto mag maximaal 2 MB zijn.',
        ]);

        $user = $request->user();

        // Oude foto verwijderen
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
        $user->save();

        return redirect()->route('profile-photo.edit')->with('success', 'Profielfoto opgeslagen.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
        }

        return redirect()->route('profile-photo.edit')->with('success', 'Profielfoto verwijderd.');
    }
}