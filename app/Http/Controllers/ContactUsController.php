<?php

namespace App\Http\Controllers;

use App\Exports\ContactUsExport;
use App\Models\ContactUs;
use App\Models\MasterKantor;
use App\Models\MasterSubject;
use App\Models\NotificationEmailRecipient;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kotak-masuk.view')->only(['list', 'export']);
        $this->middleware('permission:kotak-masuk.delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subject = MasterSubject::get();
        $kantor = MasterKantor::where('Status', 'Aktif')
            ->orderBy('Urutan', 'asc')
            ->get();
        $kantorUtama = $kantor->firstWhere('TipeKantor', 'Pusat') ?? $kantor->first();
        $kantorCabang = $kantor->filter(fn($k) => $k->id !== optional($kantorUtama)->id)->values();

        return view('frontend.contact-us', compact('subject', 'kantor', 'kantorUtama', 'kantorCabang'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = ContactUs::query();

                // Filter berdasarkan tanggal
                if ($request->filled('date_start') && $request->filled('date_end')) {
                    $query->whereBetween('created_at', [
                        $request->date_start . ' 00:00:00',
                        $request->date_end . ' 23:59:59'
                    ]);
                } elseif ($request->filled('date_start')) {
                    $query->whereDate('created_at', '>=', $request->date_start);
                } elseif ($request->filled('date_end')) {
                    $query->whereDate('created_at', '<=', $request->date_end);
                }

                $contacts = $query->latest('created_at')->get();

                // ✅ Format manual untuk memastikan data bersih
                $formattedData = $contacts->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'NamaLengkap' => $contact->NamaLengkap,
                        'Email' => $contact->Email,
                        'NomorHandphone' => $contact->NomorHandphone,
                        'CompanyName' => $contact->CompanyName,
                        'LokasiPerusahaan' => $contact->LokasiPerusahaan,
                        'ProdukYangDibutuhkan' => $contact->ProdukYangDibutuhkan,
                        'Pesan' => $contact->Pesan,
                        'IsRead' => (bool) $contact->IsRead,  // ✅ Force boolean
                        'ReadAt' => $contact->ReadAt ? $contact->ReadAt->format('Y-m-d H:i:s') : null,
                        'created_at' => $contact->created_at ? $contact->created_at->format('Y-m-d H:i:s') : null,
                        'updated_at' => $contact->updated_at ? $contact->updated_at->format('Y-m-d H:i:s') : null,
                    ];
                });

                $unreadCount = ContactUs::where('IsRead', false)
                    ->whereNull('deleted_at')
                    ->count();

                return response()->json([
                    'data' => $formattedData,
                    'unread_count' => $unreadCount,
                ]);

            } catch (\Exception $e) {
                // ✅ Log error untuk debugging
                \Log::error('Contact list error: ' . $e->getMessage());

                return response()->json([
                    'data' => [],
                    'unread_count' => 0,
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return view('pages.admin.contact.list');
    }

    public function export(Request $request)
    {
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');

        return Excel::download(new ContactUsExport($dateStart, $dateEnd), 'contact-us-' . date('Y-m-d') . '.xlsx');
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
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'NomorHandphone' => 'nullable|string|max:30',
            'CompanyName' => 'nullable|string|max:255',
            'LokasiPerusahaan' => 'nullable|string|max:255',
            'ProdukYangDibutuhkan' => 'nullable|string|max:255',
            'Subjek' => 'required|string|max:255',
            'Pesan' => 'nullable|string|max:2000',
        ]);

        // Simpan ke database
        $contact = ContactUs::create($validatedData);

        // Activity log - Menambahkan kontak baru
        activity()
            // ->causedBy(auth()->user()) // Tidak ada user untuk entry dari frontend, bisa diaktifkan jika butuh
            ->performedOn($contact)
            ->withProperties(['attributes' => $validatedData])
            ->log('Menambahkan kontak baru: ' . $validatedData['NamaLengkap']);

        $websiteSettings = PengaturanWebsite::first();
        $penerima = NotificationEmailRecipient::where('StatusAktif', 1)->where('TerimaEmail', 1)->pluck('Email')->filter()->all();
        // dd($penerima);
        if (empty($penerima)) {
            if ($websiteSettings?->Email) {
                $penerima = [$websiteSettings->Email];
            } else {
                $penerima = [];
            }
        }
        if (!empty($penerima)) {
            Mail::send('emails.contact-us', ['data' => $validatedData], function ($message) use ($penerima, $validatedData) {
                $message
                    ->to($penerima)
                    ->replyTo($validatedData['Email'], $validatedData['NamaLengkap'])
                    ->subject('📩 Pesan Baru dari ' . $validatedData['NamaLengkap'] . ' — ' . $validatedData['Subjek']);
            });
        }
        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah berhasil terkirim. Terima kasih telah menghubungi kami!'
        ]);
    }
    /**
     * Tandai pesan sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        // dd
        $contact = ContactUs::find($id);
        // dd($contact);
        $contact->update([
            'IsRead' => true,
            'ReadAt' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sebagai sudah dibaca.',
        ]);
    }

    /**
     * Tandai pesan sebagai belum dibaca
     */
    public function markAsUnread($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->update([
            'IsRead' => false,
            'ReadAt' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sebagai belum dibaca.',
        ]);
    }

    /**
     * Tandai semua sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        $count = ContactUs::where('IsRead', false)->update([
            'IsRead' => true,
            'ReadAt' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$count} pesan ditandai sebagai sudah dibaca.",
        ]);
    }

    /**
     * Hitung jumlah pesan belum dibaca
     */
    public function unreadCount()
    {
        $count = ContactUs::where('IsRead', false)->count();
        return response()->json(['unread_count' => $count]);
    }

    public function show(ContactUs $contactUs)
    {
        //
    }

    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $contact = ContactUs::findOrFail($id);
            $contact->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Pesan dari ' . ($contact->NamaLengkap ?? 'kontak') . ' berhasil dihapus.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Pesan tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat menghapus pesan.',
            ], 500);
        }
    }
}
