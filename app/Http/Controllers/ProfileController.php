<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Display user profile
     */
    public function show(User $user)
    {
        $posts = $user->posts()->latest()->get();
        return view('profile.show', compact('user', 'posts'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'motor_merk' => 'nullable|string|max:255',
            'motor_type' => 'nullable|string|max:255',
            'motor_year' => 'nullable|string|max:4',
            'motor_odo' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:51200'
        ]);

        try {
            $user = auth()->user();
            $data = $request->except('avatar');

            if ($request->hasFile('avatar')) {
                // Hapus avatar lama jika ada
                if ($user->avatar_public_id) {
                    \Log::info('Menghapus avatar lama: ' . $user->avatar_public_id);
                    Cloudinary::destroy($user->avatar_public_id);
                }

                // Upload avatar baru
                \Log::info('Mengupload avatar baru');
                $uploadedFile = Cloudinary::upload(
                    $request->file('avatar')->getRealPath(),
                    [
                        'folder' => 'ngabers/avatars',  // Sesuaikan dengan nama folder project
                        'transformation' => [
                            'width' => 400,
                            'height' => 400,
                            'crop' => 'fill',
                            'gravity' => 'face'
                        ]
                    ]
                );

                \Log::info('Hasil upload:', [
                    'secure_url' => $uploadedFile->getSecurePath(),
                    'public_id' => $uploadedFile->getPublicId()
                ]);

                $data['avatar'] = $uploadedFile->getSecurePath();
                $data['avatar_public_id'] = $uploadedFile->getPublicId();
            }

            $user->update($data);

            return redirect()->route('profile.show', $user)
                            ->with('success', 'Profile berhasil diupdate!');

        } catch (\Exception $e) {
            \Log::error('Error saat update profile: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate profile: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus avatar dari Cloudinary jika ada
        if ($user->avatar_public_id) {
            Cloudinary::destroy($user->avatar_public_id);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
