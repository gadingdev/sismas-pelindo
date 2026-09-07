<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|unique:users,nip,' . $user->id,
            'foto' => 'nullable|image|max:10240',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('foto_profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('profil.index')
            ->with('success', 'Profil berhasil diupdate!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profil.index')
            ->with('success', 'Password berhasil diubah!');
    }
}