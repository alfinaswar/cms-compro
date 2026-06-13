<?php

namespace App\Http\Controllers;

use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * (NOTE: default implementation is empty, but let's add activity log here if ever used)
     */
    public function store(Request $request)
    {
        // Example skeleton for store, just in case
        // If you ever enable this, ensure to include activity log as per update below.
    }

    /**
     * Display the specified resource.
     */
    public function show(PengaturanWebsite $pengaturanWebsite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $pengaturan = PengaturanWebsite::firstOrCreate([]);

        return view('pengaturan.website.edit', compact('pengaturan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $pengaturan = PengaturanWebsite::firstOrCreate([]);

        $request->merge([
            'ModeMaintenance' => $request->has('ModeMaintenance') ? 1 : 0,
            'AktifkanCookieConsent' => $request->has('AktifkanCookieConsent') ? 1 : 0,
        ]);

        $validated = $request->validate([
            // Identitas
            'NamaPerusahaan' => 'required|string|max:255',
            'NamaSingkat' => 'nullable|string|max:100',
            'TaglineWebsite' => 'nullable|string|max:255',
            'DeskripsiSingkat' => 'nullable|string|max:500',
            'TentangPerusahaan' => 'nullable|string',
            // Branding
            'WarnaUtama' => 'nullable|string|size:7',
            'WarnaSekunder' => 'nullable|string|size:7',
            'FontUtama' => 'nullable|string|max:50',
            'PathLogo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'PathLogoGelap' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'PathFavicon' => 'nullable|mimes:ico,png|max:512',
            'PathOgImage' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            // Kontak
            'NomorTelepon' => 'nullable|string|max:50',
            'NomorWhatsApp' => 'nullable|string|max:50',
            'AlamatEmail' => 'nullable|email|max:255',
            'AlamatKantor' => 'nullable|string',
            'Kota' => 'nullable|string|max:100',
            'KodePos' => 'nullable|string|max:20',
            'Provinsi' => 'nullable|string|max:100',
            'Negara' => 'nullable|string|max:100',
            'TautanGoogleMaps' => 'nullable|url|max:255',
            'EmbedGoogleMaps' => 'nullable|string',
            // Sosial Media
            'SosialFacebook' => 'nullable|url|max:255',
            'SosialInstagram' => 'nullable|url|max:255',
            'SosialTwitter' => 'nullable|url|max:255',
            'SosialLinkedIn' => 'nullable|url|max:255',
            'SosialYoutube' => 'nullable|url|max:255',
            'SosialTiktok' => 'nullable|url|max:255',
            // Legal
            'NomorNIB' => 'nullable|string|max:100',
            'NomorNPWP' => 'nullable|string|max:100',
            'PathLogoNPWP' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'NamaDirektur' => 'nullable|string|max:255',
            'JabatanDirektur' => 'nullable|string|max:255',
            'RekeningBank' => 'nullable|string',
            // SEO & Analytics
            'KataKunciSEO' => 'nullable|string',
            'PenulisMeta' => 'nullable|string|max:255',
            'IdGoogleAnalytics' => 'nullable|string|max:50',
            'IdGoogleTagManager' => 'nullable|string|max:50',
            'ScriptHeaderCustom' => 'nullable|string',
            // Operasional
            'JamOperasional' => 'nullable|string|max:255',
            'ZonaWaktu' => 'nullable|string|max:50',
            'BahasaDefault' => 'nullable|string|max:20',
            // System
            'ModeMaintenance' => 'nullable|boolean',
            'PesanMaintenance' => 'nullable|string|max:255',
            'AktifkanCookieConsent' => 'nullable|boolean',
            'TeksCookieConsent' => 'nullable|string',
            // Footer
            'TeksCopyright' => 'nullable|string|max:255',
            'TautanKebijakanPrivasi' => 'nullable|url|max:255',
            'TautanSyaratKetentuan' => 'nullable|url|max:255',
        ], [
            'NamaPerusahaan.required' => 'Nama perusahaan wajib diisi.',
            'AlamatEmail.email' => 'Format email tidak valid.',
            'WarnaUtama.size' => 'Format warna harus hex 7 karakter (contoh: #0d6efd).',
            'PathLogo.image' => 'File logo harus berupa gambar.',
        ]);

        // Daftar field yang berupa file upload
        $fileFields = ['PathLogo', 'PathLogoGelap', 'PathFavicon', 'PathOgImage', 'PathLogoNPWP'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $newPath = $file->store('pengaturan', 'public');

                // Hapus file lama jika ada
                $oldPath = $pengaturan->{$field};
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $validated[$field] = $newPath;
            }
        }

        // Catat data lama untuk log
        $oldData = $pengaturan->getOriginal();

        $pengaturan->update($validated);
        PengaturanWebsite::clearCache();

        // Activity log
        activity()
            ->performedOn($pengaturan)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $oldData,
                'attributes' => $pengaturan->toArray()
            ])
            ->log('Memperbarui pengaturan website.');

        return redirect()
            ->route('pengaturan-website.edit')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengaturanWebsite $pengaturanWebsite)
    {
        //
    }
}
