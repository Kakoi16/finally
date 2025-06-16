<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    // ... (metode saveProfile tetap sama)
    public function saveProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $profileData = $request->only(['phone_number', 'address', 'bio', 'tanggal_lahir']);
        if (empty($profileData['tanggal_lahir'])) {
            $profileData['tanggal_lahir'] = null;
        }

        Profile::updateOrCreate(['user_id' => $user->id], $profileData);
        
        $user->refresh()->load('profile');
        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'user_data' => $user
        ], 200);
    }

    /**
     * Metode ini sekarang sudah bisa menghapus foto lama secara otomatis.
     */
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // Dapatkan path foto lama SEBELUM kita melakukan apapun.
        $oldPicturePath = $user->profile?->profile_picture_path;

        if ($request->hasFile('profile_picture')) {
            // Simpan foto baru ke storage.
            $newPath = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Update database dengan path foto yang baru.
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['profile_picture_path' => $newPath]
            );

            // Jika ada path foto lama, hapus file tersebut dari storage.
            if ($oldPicturePath) {
                Storage::disk('public')->delete($oldPicturePath);
            }

            return response()->json([
                'message' => 'Foto profil berhasil diunggah dan foto lama telah dihapus.',
            ]);
        }

        return response()->json(['message' => 'Tidak ada file yang diunggah.'], 400);
    }

    // ... (metode getCurrentUserProfile, downloadProfileFile, dan displayProfilePicture tetap sama)
    public function getCurrentUserProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json($user->load('profile'));
    }
    
    public function displayProfilePicture(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->profile) {
            return response()->json(['message' => 'Profil tidak ditemukan.'], 404);
        }

        $path = $user->profile->profile_picture_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            // Mengembalikan gambar default jika tidak ada foto atau file tidak ditemukan
            // Pastikan Anda punya gambar default di public/images/default-avatar.png
            $defaultPath = public_path('images/default-avatar.png');
            if (file_exists($defaultPath)) {
                return response()->file($defaultPath);
            }
            return response()->json(['message' => 'File foto profil tidak ditemukan.'], 404);
        }
        
        return Storage::disk('public')->response($path);
    }

        public function downloadProfileFile(Request $request)
    {
        $filePath = 'public/exports/profil-export.pdf';
        if (!Storage::exists($filePath)) {
             return response()->json(['message' => 'File tidak ditemukan.'], 404);
        }
        $absolutePath = Storage::path($filePath);
        $fileName = 'profil-export-user.pdf';
        $mimeType = Storage::mimeType($filePath);
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="'. $fileName .'"',
        ];
        return response()->download($absolutePath, $fileName, $headers);
    }
    
    public function changePassword(Request $request)
{
    $user = $request->user();

    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'message' => 'Password saat ini salah'
        ], 403);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json([
        'message' => 'Password berhasil diubah'
    ], 200);
}
}