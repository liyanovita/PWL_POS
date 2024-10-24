<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profil',
            'list' => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'Data Profil Pengguna'
        ];

        $activeMenu = 'profile'; // Set the active menu

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }
    

    public function update_profile(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
    
        // Get the logged-in user's ID
        $userId = Auth::id();
        $user = UserModel::find($userId);
    
        if ($request->hasFile('avatar')) {
            // Delete old profile picture if it exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
    
            // Store new profile picture publicly
            $path = $request->file('avatar')->store('images/profiles', 'public');
    
            // Check if the file was saved successfully
            if ($path) {
                $user->avatar = $path;
                $user->save();
                return redirect()->back()->with('success', 'Profile picture updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to upload the profile picture');
            }
        } else {
            return redirect()->back()->with('error', 'No file uploaded');
        }
    }
    

    public function update_pengguna(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id', // username harus unik
            'nama' => 'required|string|max:100', // nama harus diisi dan maksimal 100 karakter
        ]);

        // Mengambil pengguna berdasarkan ID
        $user = UserModel::find($id);

        // Update data pengguna
        $user->username = $request->username;
        $user->nama = $request->nama;

        // Simpan perubahan
        $user->save();

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function update_password(Request $request, string $id)
    {
        // Custom validation rules
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:5', // Password minimal 5 karakter
            'new_password_confirmation' => 'required|same:new_password', // Verifikasi password harus sama dengan password baru
        ], [
            'new_password.min' => 'Password minimal harus 5 karakter', // Pesan kesalahan kustom
            'new_password_confirmation.same' => 'Verifikasi password yang anda masukkan tidak sesuai dengan password baru', // Pesan kesalahan kustom
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Cek error untuk new_password dan new_password_confirmation
            if ($validator->errors()->has('new_password')) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->with('error_type', 'new_password'); // Tetap di tab "Ubah Password"
            }

            if ($validator->errors()->has('new_password_confirmation')) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->with('error_type', 'new_password_confirmation'); // Tetap di tab "Ubah Password"
            }
        }

        // Ambil user berdasarkan ID
        $user = UserModel::find($id);

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai'])
                ->with('error_type', 'current_password'); // Tetap di tab "Ubah Password"
        }

        // Jika validasi lolos, ubah password user
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
}
