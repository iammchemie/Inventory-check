<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->roleId == 1 || auth()->user()->roleId == 2) {
                return redirect()->intended('/dashboard');
            } elseif (auth()->user()->roleId == 3) {
                return redirect()->intended('/reagensia');
            } else {
                return redirect()->intended('/');
            }
        }

        return back()->with('error', 'Maaf, email dan password yang Anda masukkan tidak valid. Silakan coba lagi.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function v_register(Request $request)
    {
        return view('Login.registrasi');
    }
    public function register(Request $request)
    {
        $customMessages = [
            'required' => 'Field :attribute harus diisi.',
            'max' => 'Field :attribute tidak boleh lebih dari :max karakter.',
            'unique' => 'Field :attribute sudah ada dalam database.',
            'min' => 'Field :attribute minimal harus :min.',
            'email' => 'Field :attribute harus dalam format alamat email yang valid.',

        ];

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], $customMessages);
        // dd($validatedData);


        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/login')->with('success', 'Pendaftaran berhasil.');
    }
}