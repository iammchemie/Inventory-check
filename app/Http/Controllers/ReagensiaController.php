<?php

namespace App\Http\Controllers;

use App\Exports\reagenExport;
use App\Imports\reagenImport;
use App\Models\Reagensia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReagensiaController extends Controller
{
    public function index(Request $request)
    {
        return view('reagensia.index', [
            'title' => 'Inventaris Reagensia',
            'user' => $request,
            'reagensia' => Reagensia::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function exportexcel()
    {
        return Excel::download(new reagenExport, 'reagensia.xlsx');
    }
    public function importexcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Validasi jenis file
        ]);

        $file = $request->file('file');

        // Lakukan impor menggunakan class NamaImport
        Excel::import(new reagenImport, $file);

        return redirect()->back()->with('success', 'Data berhasil diimpor');
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

    public function hapusreagensia(Request $request, $id)
    {
        $data = Reagensia::findOrFail($id);
        $data->delete();
        return redirect('/reagensia')->with('success', 'Data Reagensia berhasil dihapus!');
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
            'tanggal_kadaluarsa' => 'required|date',
            'keterangan' => 'nullable|max:255',
        ], $customMessages);



        Reagensia::where('id', $id)->update($validatedData);

        return redirect('/reagensia')->with('success', 'Data Berhasil dirubah');
    }
}