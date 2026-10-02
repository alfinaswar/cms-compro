<?php

namespace App\Http\Controllers;

use App\Models\NotificationEmailRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class NotificationEmailRecipientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengaturan-form-kontak.view')->only(['index']);
        $this->middleware('permission:pengaturan-form-kontak.create')->only(['store']);
        $this->middleware('permission:pengaturan-form-kontak.edit')->only(['update']);
        $this->middleware('permission:pengaturan-form-kontak.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        // Jika request AJAX dari DataTables
        if ($request->ajax()) {
            $data = NotificationEmailRecipient::select('id', 'Email', 'Nama', 'StatusAktif', 'created_at')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Status', function ($row) {
                    return $row->StatusAktif
                        ? '<span class="badge badge-success px-2 py-1">Aktif</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('pengaturan-form-kontak.edit')) {
                        $btn .= '<button type="button" class="btn btn-info btn-sm btn-edit mr-1" data-id="' . $row->id . '" data-email="' . $row->Email . '" data-nama="' . $row->Nama . '" data-toggle="modal" data-target="#modalEmail" title="Edit">';
                        $btn .= '<i class="fas fa-edit"></i></button>';
                    }
                    if (auth()->user()->can('pengaturan-form-kontak.delete')) {
                        $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-email="' . $row->Email . '" title="Hapus">';
                        $btn .= '<i class="fas fa-trash"></i></button>';
                    }
                    return $btn;
                })
                ->rawColumns(['Status', 'action'])
                ->make(true);
        }

        // Return view biasa untuk load pertama kali
        return view('pages.admin.notification-email.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|email|unique:notification_email_recipient,Email',
            'Nama' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        NotificationEmailRecipient::create([
            'Email' => $request->Email,
            'Nama' => $request->Nama,
            'StatusAktif' => true,
            'UserCreate' => auth()->user()->name,
        ]);

        return response()->json(['message' => 'Email berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        // Validasi: abaikan email yang sedang diedit agar tidak dianggap duplikat terhadap dirinya sendiri
        $validator = Validator::make($request->all(), [
            'Email' => 'required|email|unique:notification_email_recipient,Email,' . $id,
            'Nama' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $recipient = NotificationEmailRecipient::findOrFail($id);

        $recipient->update([
            'Email' => $request->Email,
            'Nama' => $request->Nama,
            'UserUpdate' => auth()->user()->name,
        ]);

        return response()->json(['message' => 'Data email berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        // dd($id);
        $recipient = NotificationEmailRecipient::findOrFail($id);

        // Opsional: catat siapa yang menghapus
        $recipient->UserDelete = auth()->user()->name;
        $recipient->save();

        $recipient->delete();

        return response()->json(['message' => 'Email berhasil dihapus dari daftar notifikasi.']);
    }
}
