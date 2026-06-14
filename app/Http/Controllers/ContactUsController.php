<?php

namespace App\Http\Controllers;

use App\Exports\ContactUsExport;
use App\Models\ContactUs;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.contact-us');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::query();

            // Filter berdasarkan tanggal
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $data->whereBetween('created_at', [
                    $request->date_start . ' 00:00:00',
                    $request->date_end . ' 23:59:59'
                ]);
            } elseif ($request->filled('date_start')) {
                $data->whereDate('created_at', '>=', $request->date_start);
            } elseif ($request->filled('date_end')) {
                $data->whereDate('created_at', '<=', $request->date_end);
            }

            $data->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-info btn-detail" data-id="' . $row->id . '" title="Detail">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                ';
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
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
        $validatedData = $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'NomorHandphone' => 'nullable|string|max:30',
            'CompanyName' => 'nullable|string|max:255',
            'LokasiPerusahaan' => 'nullable|string|max:255',
            'ProdukYangDibutuhkan' => 'nullable|string|max:255',
            'Pesan' => 'nullable|string|max:2000',
        ]);

        // Simpan ke database
        ContactUs::create($validatedData);

        // Ambil email tujuan dari pengaturan website
        $websiteSettings = PengaturanWebsite::first();
        $toEmail = $websiteSettings?->Email;

        // Kirim email dengan template
        if ($toEmail) {
            Mail::send('emails.contact-us', ['data' => $validatedData], function ($message) use ($toEmail, $validatedData) {
                $message
                    ->to($toEmail)
                    ->replyTo($validatedData['Email'], $validatedData['NamaLengkap'])
                    ->subject('📩 Pesan Baru dari ' . $validatedData['NamaLengkap'] . ' — Contact Us');
            });
        }

        // Return JSON response untuk AJAX
        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah berhasil terkirim. Terima kasih telah menghubungi kami!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
