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
            $locale = app()->getLocale();

            // Urutkan: Parent (NULL) dulu, lalu berdasarkan ParentId, lalu Urutan
            $data = CustomPage::with([
                'translations' => function ($q) use ($locale) {
                    $q->where('Locale', $locale);
                },
                'parent'
            ])
                ->orderByRaw("CASE WHEN ParentId IS NULL THEN 0 ELSE 1 END")
                ->orderBy('ParentId')
                ->orderBy('Urutan', 'asc');

            // Filter Status (jika ada)
            if ($request->filled('status')) {
                $data->where('IsPublished', $request->status === 'Diterbitkan' ? 1 : 0);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('JudulDisplay', function ($row) {
                    $trans = $row->translations->first();
                    $nama = $trans ? $trans->Judul : $row->Judul;

                    // Visual Indentation berdasarkan level
                    $indent = '';
                    if ($row->level > 0) {
                        $indent = str_repeat('<span style="display:inline-block; width: 20px; border-left: 1px solid #cbd5e1; margin-right: 4px;"></span>', $row->level);
                    }

                    // Icon berbeda untuk Parent vs Child
                    $icon = $row->ParentId
                        ? '<i class="fa fa-file-alt text-muted mr-2"></i>'
                        : '<i class="fa fa-folder text-warning mr-2"></i>';

                    return $indent . $icon . '<strong class="text-dark">' . $nama . '</strong>';
                })
                ->addColumn('Thumbnail', function ($row) {
                    return $row->Thumbnail
                        ? '<img src="' . asset('storage/' . $row->Thumbnail) . '" style="width:60px; height:40px; object-fit:cover; border-radius:6px; border: 1px solid #edf2f7;">'
                        : '<span class="text-muted" style="font-size:12px;">No Image</span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    return $row->IsPublished
                        ? '<span class="badge badge-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Diterbitkan</span>'
                        : '<span class="badge badge-secondary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Draf</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('custom-pages.edit', $row->id) . '" class="btn btn-sm btn-light border" title="Edit" style="color: #2563eb;"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<button class="btn btn-sm btn-light border btn-delete" data-id="' . $row->id . '" data-nama="' . $row->translate('id')->Judul . '" title="Hapus" style="color: #ef4444;"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['JudulDisplay', 'Thumbnail', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.custom-pages.index');
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
