<?php

namespace App\Http\Controllers;

use App\Models\NotificationEmailRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class NotificationEmailRecipientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationEmailRecipient::select('id', 'Email', 'Nama', 'StatusAktif', 'created_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Status', function ($row) {
                    return $row->StatusAktif
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-secondary">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-info btn-sm btn-edit" data-id="' . $row->id . '" data-email="' . $row->Email . '" data-nama="' . $row->Nama . '" data-toggle="modal" data-target="#modalEmail">';
                    $btn .= '<i class="fas fa-edit"></i></button> ';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-email="' . $row->Email . '">';
                    $btn .= '<i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['Status', 'action'])
                ->make(true);
        }

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

        return response()->json(['message' => 'Email berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $recipient = NotificationEmailRecipient::findOrFail($id);
        $recipient->update(['UserDelete' => auth()->user()->name]);
        $recipient->delete();

        return response()->json(['message' => 'Email berhasil dihapus.']);
    }
}
