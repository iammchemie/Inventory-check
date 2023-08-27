<?php

namespace App\Http\Controllers;

use App\Exports\reagenExport;
use App\Models\Reagensia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.dashboard', [
            'title' => 'Dashboard',
            'user' => $request,
            'reagensia' => Reagensia::paginate(10),
        ]);
    }
    public function reagensia(Request $request)
    {
        return view('dashboard.reagensia', [
            'title' => 'Inventaris Reagensia',
            'user' => $request,
            'reagensia' => Reagensia::paginate(10),
        ]);
    }
    public function tambahreagensia(Request $request)
    {
        $customMessages = [
            'required' => 'Field :attribute harus diisi.',
            'max' => 'Field :attribute tidak boleh lebih dari :max karakter.',
            'unique' => 'Field :attribute sudah ada dalam database.',
            'date' => 'Field :attribute harus dalam format tanggal yang valid.',
            'after_or_equal' => 'Field :attribute harus setelah atau sama dengan tanggal :date.',
            'before_or_equal' => 'Field :attribute harus sebelum atau sama dengan tanggal :date.',
            'integer' => 'Field :attribute harus berupa angka.',
            'min' => 'Field :attribute minimal harus :min.',
        ];

        $validatedData = $request->validate([
            'nama_reagensia' => 'required|max:255',
            'satuan' => 'required|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
            'jumlah_masuk' => 'required|integer|min:0',
            'jumlah_keluar' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:today',
            'keterangan' => 'required|max:255',
        ], $customMessages);

        $saldo = $validatedData['jumlah_masuk'] - $validatedData['jumlah_keluar'];
        $validatedData['stok'] = $saldo;

        Reagensia::create($validatedData);

        return redirect('/reagensia')->with('success', 'Data reagensia berhasil ditambahkan.');
    }
    public function usermanagement(Request $request)
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

    public function exportexcel()
    {
        return Excel::download(new reagenExport, 'reagensia.xlsx');
    }
}
