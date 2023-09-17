<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.usermanagement', [
            'title' => 'User Management',
            'user' => $request,
            'users' => User::paginate(10)
        ]);
    }

    public function ubahpassword(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "password$id" => 'required|min:8',
            "repassword$id" => 'required|same:password' . $id . '|min:8',
        ], [
            'required' => 'Field :attribute harus diisi.',
            'min' => 'Field :attribute tidak boleh lebih dari :min karakter.',
            'same' => 'Field :attribute harus sama dengan Password.',
        ]);

        User::where('id', $id)->update([
            'password' => Hash::make($validatedData["password$id"]),
        ]);

        return redirect('/user-management')->with('success', 'Password Berhasil dirubah');
    }

    public function editRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            "role$id" => 'required',
        ]);

        User::where('id', $id)->update(['RoleId' => $validatedData["role$id"]]);

        return redirect('/user-management')->with('success', 'Role Berhasil dirubah');
    }
}
