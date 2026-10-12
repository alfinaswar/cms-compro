<?php

namespace App\Http\Controllers;

use App\Models\NotificationEmailRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class NotificationEmailRecipientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationEmailRecipient::select('id', 'Email', 'Nama', 'StatusAktif', 'TerimaEmail', 'created_at')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Toggle TerimaEmail
                ->addColumn('TerimaEmail', function ($row) {
                    $checked = $row->TerimaEmail ? 'checked' : '';
                    $canEdit = auth()->user()->can('pengaturan-form-kontak.edit');

                    if ($canEdit) {
                        return '
                        <div class="custom-control custom-switch d-inline-block m-0">
                            <input type="checkbox"
                                   class="custom-control-input toggle-terima-email"
                                   id="terima_email_' . $row->id . '"
                                   data-id="' . $row->id . '"
                                   ' . $checked . '>
                            <label class="custom-control-label mb-0" for="terima_email_' . $row->id . '"></label>
                        </div>';
                    }

                    // Fallback jika tidak punya permission
                    return $row->TerimaEmail
                        ? '<span class="badge badge-success px-2 py-1">Ya</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Tidak</span>';
                })

                // ✅ Toggle StatusAktif
                ->addColumn('Status', function ($row) {
                    $checked = $row->StatusAktif ? 'checked' : '';
                    $canEdit = auth()->user()->can('pengaturan-form-kontak.edit');

                    if ($canEdit) {
                        return '
                        <div class="custom-control custom-switch d-inline-block m-0">
                            <input type="checkbox"
                                   class="custom-control-input toggle-status"
                                   id="status_' . $row->id . '"
                                   data-id="' . $row->id . '"
                                   ' . $checked . '>
                            <label class="custom-control-label mb-0" for="status_' . $row->id . '">
                                <span class="status-label-' . $row->id . '">'
                            . ($row->StatusAktif ? 'Aktif' : 'Nonaktif') .
                            '</span>
                            </label>
                        </div>';
                    }

                    return $row->StatusAktif
                        ? '<span class="badge badge-success px-2 py-1">Aktif</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Nonaktif</span>';
                })

                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('pengaturan-form-kontak.edit')) {
                        $btn .= '<button type="button" class="btn btn-info btn-sm btn-edit mr-1"
                                    data-id="' . $row->id . '"
                                    data-email="' . $row->Email . '"
                                    data-nama="' . $row->Nama . '"
                                    data-terima-email="' . ($row->TerimaEmail ? '1' : '0') . '"
                                    data-toggle="modal"
                                    data-target="#modalEmail"
                                    title="Edit">';
                        $btn .= '<i class="fas fa-edit"></i></button>';
                    }
                    if (auth()->user()->can('pengaturan-form-kontak.delete')) {
                        $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete"
                                    data-id="' . $row->id . '"
                                    data-email="' . $row->Email . '"
                                    title="Hapus">';
                        $btn .= '<i class="fas fa-trash"></i></button>';
                    }
                    return $btn;
                })
                ->rawColumns(['TerimaEmail', 'Status', 'action'])
                ->make(true);
        }

        return view('pages.admin.notification-email.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|email|unique:notification_email_recipient,Email',
            'Nama' => 'nullable|string|max:255',
            'TerimaEmail' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $recipient = NotificationEmailRecipient::create([
            'Email' => $request->Email,
            'Nama' => $request->Nama,
            'TerimaEmail' => $request->has('TerimaEmail'),
            'StatusAktif' => true,
            'UserCreate' => auth()->user()->name,
        ]);

        // Activity log penambahan email recipient
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'Email' => $recipient->Email,
                'Nama' => $recipient->Nama,
                'StatusAktif' => $recipient->StatusAktif,
                'TerimaEmail' => $recipient->TerimaEmail,
                'ip_address' => $request->ip(),
            ])
            ->log('Menambah email notifikasi baru');

        return response()->json(['message' => 'Email berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|email|unique:notification_email_recipient,Email,' . $id,
            'Nama' => 'nullable|string|max:255',
            'TerimaEmail' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $recipient = NotificationEmailRecipient::findOrFail($id);

        $oldRecipient = $recipient->replicate();

        $recipient->update([
            'Email' => $request->Email,
            'Nama' => $request->Nama,
            'TerimaEmail' => $request->has('TerimaEmail'),
            'UserUpdate' => auth()->user()->name,
        ]);

        // Activity log update
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'before' => [
                    'Email' => $oldRecipient->Email,
                    'Nama' => $oldRecipient->Nama,
                    'TerimaEmail' => $oldRecipient->TerimaEmail,
                ],
                'after' => [
                    'Email' => $recipient->Email,
                    'Nama' => $recipient->Nama,
                    'TerimaEmail' => $recipient->TerimaEmail,
                ],
                'ip_address' => $request->ip(),
            ])
            ->log('Mengubah data email notifikasi');

        return response()->json(['message' => 'Data email berhasil diperbarui.']);
    }

    public function toggleStatus($id)
    {
        $recipient = NotificationEmailRecipient::findOrFail($id);
        $recipient->StatusAktif = !$recipient->StatusAktif;
        $recipient->UserUpdate = auth()->user()->name;
        $recipient->save();

        // Activity log ubah status aktif/tidak
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'Email' => $recipient->Email,
                'StatusAktif' => $recipient->StatusAktif,
                'ip_address' => request()->ip(),
            ])
            ->log('Mengubah status aktif email notifikasi');

        return response()->json([
            'success' => true,
            'message' => 'Status email berhasil diubah menjadi ' . ($recipient->StatusAktif ? 'Aktif' : 'Nonaktif'),
            'status' => $recipient->StatusAktif,
        ]);
    }

    // ✅ Method baru untuk toggle TerimaEmail
    public function toggleTerimaEmail($id)
    {
        $recipient = NotificationEmailRecipient::findOrFail($id);
        $recipient->TerimaEmail = !$recipient->TerimaEmail;
        $recipient->UserUpdate = auth()->user()->name;
        $recipient->save();

        // Activity log toggle terima email (on/off)
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'Email' => $recipient->Email,
                'TerimaEmail' => $recipient->TerimaEmail,
                'ip_address' => request()->ip(),
            ])
            ->log('Mengubah status Terima Email notifikasi');

        return response()->json([
            'success' => true,
            'message' => 'Status terima email berhasil diubah menjadi ' . ($recipient->TerimaEmail ? 'Ya' : 'Tidak'),
            'terima_email' => $recipient->TerimaEmail,
        ]);
    }
}
