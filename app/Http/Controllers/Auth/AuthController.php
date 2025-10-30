<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivateAccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function regis()
    {
        return view('pages.auth.register');
    }

    public function regisStore(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'username' => 'required|string|max:50|unique:users',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        // ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['role'] = 'user';
        $data['status'] = 'not_active';
        // dd($data);

        $user = User::create($data);

        // kirim email aktivasi
        Mail::to($user->email)->send(new ActivateAccountMail($user));

        return redirect()->route('login')
            ->with('message', 'Registrasi berhasil! Silakan cek email Anda untuk mengaktifkan akun.');
    }

    public function activate($token)
    {
        $email = base64_decode($token);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->with('message', 'Token aktivasi tidak valid.');
        }

        $user->update(['status' => 'active']);

        return redirect()->route('login')->with('message', 'Akun berhasil diaktifkan! Silakan login.');
    }   

    public function login_action(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek status akun
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->back()->with('message', 'Akun Anda belum aktif. Silakan cek email untuk aktivasi.');
            }

            Session::put('user_id', $user->id);
            Session::put('name', $user->name);
            Session::put('username', $user->username);
            Session::put('role', $user->role);
            Session::put('cek', true);

            return redirect()->route('admin')->with('message', 'Sukses login');
        }

        return redirect()->back()->with('message', 'Username atau password salah.');
    }
}
