<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login_post()
    {
        request()->validate([
            'email' => 'required|email',
            'pass' => 'required|min:8'
        ],[
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'pass.required' => 'Password harus di isi',
            'pass.min' => 'Password min 8 karakter'
        ]);

        if(Auth::attempt(['email' => request('email'), 'password' =>request('pass')])){
            if(Auth::user()->role == 'admin'){
                return redirect('dashboard');
            }elseif(Auth::user()->role == 'member'){
                return redirect('home');
            }else{
                return redirect('login');
            }
        }

        return redirect('/')->with('error', 'Email dan Password tidak sesuai');
    }

    public function register()
    {
        return view('register');
    }

    public function register_post()
    {
        request()->validate([
            'nama' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'pass' => 'required|min:8',
            'konfirmasi_password' => 'required|same:pass'
        ],[
            'nama.required' => 'Nama harus di isi',
            'role.required' => 'Hak access harus di pilih',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'pass.required' => 'Password harus di isi',
            'pass.min' => 'Password minimal 8 karakter',
            'konfirmasi_password.required' => 'Konfirmasi password harus di isi',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        User::create([
            'name' => ucwords(request('nama')),
            'email' => request('email'),
            'role' => request('role'),
            'password' => bcrypt(request('pass'))
        ]);

        return redirect('/')->with('message', 'Anda telah terdaftar, silahkan login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('message', 'Anda telah keluar');
    }
}
