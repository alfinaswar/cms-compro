<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporanKeuangan;
use App\Models\LaporanKeuanganDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanKeuanganDetailController extends Controller
{
    public function index($jenisId)
    {
        $jenis = JenisLaporanKeuangan::findOrFail($jenisId);
        $details = $jenis->allDetails()->get();

        return view('master.jenis-laporan.detail', compact('jenis', 'details'));
    }

    public function store(Request $request, $jenisId)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'PathFile' => 'required|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'TahunPeriode' => 'required|date',
            'Bahasa' => 'required|in:ID,EN',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathFile')) {
            $file = $request->file('PathFile');
            $validated['PathFile'] = $file->store('laporan-keuangan', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2);
        }

        $validated['JenisLaporanId'] = $jenisId;
        $validated['UserCreate'] = auth()->user()->name;
        $validated['JumlahDownload'] = 0;

        LaporanKeuanganDetail::create($validated);

        return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $detail = LaporanKeuanganDetail::findOrFail($id);

        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'PathFile' => 'nullable|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'TahunPeriode' => 'required|date',
            'Bahasa' => 'required|in:ID,EN',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathFile')) {
            if ($detail->PathFile && Storage::disk('public')->exists($detail->PathFile)) {
                Storage::disk('public')->delete($detail->PathFile);
            }
            $file = $request->file('PathFile');
            $validated['PathFile'] = $file->store('laporan-keuangan', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2);
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $detail->update($validated);

        return response()->json(['status' => 200, 'message' => 'Dokumen berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $detail = LaporanKeuanganDetail::find($id);
        if (!$detail) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($detail->PathFile && Storage::disk('public')->exists($detail->PathFile)) {
            Storage::disk('public')->delete($detail->PathFile);
        }

        $detail->update(['UserDelete' => auth()->user()->name]);
        $detail->delete();

        return response()->json(['status' => 200, 'message' => 'Dokumen berhasil dihapus']);
    }

    public function download($id)
    {
        $detail = LaporanKeuanganDetail::findOrFail($id);
        $detail->increment('JumlahDownload');

        return Storage::disk('public')->download($detail->PathFile);
    }
}
