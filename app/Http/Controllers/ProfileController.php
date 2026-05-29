<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
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

    public function update(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validated();

        // Xử lý File riêng nếu có
        if ($request->hasFile('avt')) {
            if ($user->avt) {
                Storage::disk('public')->delete($user->avt);
            }
            $data['avt'] = $request->file('avt')->store('avatars', 'public');
        }

        // Cập nhật thông tin người dùng
        $user->update($data);

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
