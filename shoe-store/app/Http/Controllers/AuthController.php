<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Tìm người dùng theo username
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Lưu thông tin người dùng vào session
            session(['user' => $user]);

            // Chuyển hướng dựa trên vai trò
            return $user->role === 'admin'
                ? redirect('/dashboard')->with('success', 'Đăng nhập thành công!')
                : redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()->withErrors(['login_error' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }

    /**
     * Hiển thị form đăng ký.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users',
        ]);

        // Tạo người dùng mới
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'user', // Mặc định là user
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout()
    {
        session()->forget('user');
        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
