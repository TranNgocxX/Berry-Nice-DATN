<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->is_admin == 1) {
            return redirect()->route('admin.profile');
        }

        return redirect()->route('user.profile');
    }

    // in4 Admin
    public function adminProfile()
    {
        return view('admin.profile', [
            'user' => Auth::user()
        ]);
    }

    // in4 User
    public function userProfile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'birthday' => 'nullable|date',
            'phone'   => 'nullable|regex:/^[0-9]{10}$/',
            'address' => 'nullable|string',
            'avt'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'birthday' => $request->birthday,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->hasFile('avt')) {
            if ($user->avt) {
                Storage::disk('public')->delete($user->avt);
            }

            $path = $request->file('avt')->store('avatars', 'public');
            $user->avt = $path;
            $user->save();
        }

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
