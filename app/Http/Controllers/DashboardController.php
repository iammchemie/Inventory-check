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
            'reagensia' => Reagensia::paginate(5),
            'reagensiastok' => Reagensia::all(),
            'users' => User::count(),
            'user' => User::all()
        ]);
    }
    public function reagensia(Request $request)
    {
        return view('dashboard.reagensia', [
            'title' => 'Inventaris Reagensia',
            'user' => $request,
            'reagensia' => Reagensia::orderBy('created_at', 'desc')->paginate(10),
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
            'tanggal_masuk' => 'date',
            'tanggal_keluar' => 'nullable',
            'jumlah_masuk' => 'integer',
            'jumlah_keluar' => 'nullable',
            'stok' => '',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:today',
            'keterangan' => 'nullable|max:255',
        ], $customMessages);

        if ($validatedData['tanggal_keluar'] == null) {
            $validatedData['tanggal_keluar'] = null;
            $validatedData['jumlah_keluar'] = 0;
        }

        if ($validatedData['keterangan'] == null) {
            $validatedData['keterangan'] = '-';
        }

        $stok = $validatedData['stok'] + ($validatedData['jumlah_masuk'] - $validatedData['jumlah_keluar']);
        $validatedData['stok'] = $stok;

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

    public function getAPIReagensia(Request $request, $namaReagensia)
    {
        $reagensia = Reagensia::where('nama_reagensia', $namaReagensia)->latest()->first();

        if ($reagensia) {
            return response()->json([
                'satuan' => $reagensia->satuan,
                'stok' => $reagensia->stok,
            ]);
        } else {
            return response()->json([
                'satuan' => null,
                'stok' => null,
            ]);
        }
    }
    public function hapusreagensia(Request $request, $id)
    {
        $data = Reagensia::findOrFail($id);
        $data->delete();
        return redirect('/reagensia')->with('success', 'Data Reagensia berhasil dihapus!');
    }
    public function editRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            "role$id" => 'required',
        ]);

        User::where('id', $id)->update(['RoleId' => $validatedData["role$id"]]);

        return redirect('/user-management')->with('success', 'Role Berhasil dirubah');
    }
    public function ubahreagensia(Request $request, $id)
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
            'tanggal_masuk' => 'date',
            'tanggal_keluar' => 'nullable',
            'jumlah_masuk' => 'integer|max:100',
            'jumlah_keluar' => 'nullable',
            'stok' => '',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:today',
            'keterangan' => 'nullable|max:255',
        ], $customMessages);

        if ($validatedData['tanggal_keluar'] == null) {
            $validatedData['tanggal_keluar'] = null;
            $validatedData['jumlah_keluar'] = 0;
        }

        if ($validatedData['keterangan'] == null) {
            $validatedData['keterangan'] = '-';
        }


        $originalData = Reagensia::find($id);
        $originaljumlahmasuk = $originalData->jumlah_masuk;
        $originalstok = $originalData->stok;
        $originaljumlahkeluar = $originalData->jumlah_keluar;

        if ($originaljumlahmasuk == $validatedData['jumlah_masuk'] && $originaljumlahkeluar == $validatedData['jumlah_keluar']) {
            $validatedData['stok'] = $originalstok;
        }
        // else
        //     // $validatedData['stok'] = $originalstok +
        // }

        Reagensia::where('id', $id)->update($validatedData);

        return redirect('/reagensia')->with('success', 'Data Berhasil dirubah');
    }
    public function getAPIReagensiaEdit(Request $request, $namaReagensia)
    {
        $reagensia = Reagensia::where('nama_reagensia', $namaReagensia)->latest(2)->first();

        if ($reagensia) {
            return response()->json([
                'stok' => $reagensia->stok,
            ]);
        } else {
            return response()->json([
                'stok' => null,
            ]);
        }
    }
}
