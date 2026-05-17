<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.required' => 'Pilih foto terlebih dahulu!',
            'photo.image' => 'File harus berupa gambar!',
            'photo.max' => 'Ukuran foto maksimal 2MB!',
        ]);

        $user = Auth::user();
        
        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $file = $request->file('photo');
        $filename = 'profile-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profile-photos', $filename, 'public');

        // Update user profile
        $user->update(['profile_photo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diupload!',
            'photo_url' => asset('storage/' . $path),
        ]);
    }
}
