<?php

namespace App\Http\Controllers;

use App\Models\MasterSubject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:master-subject.view')->only(['index']);
        $this->middleware('permission:master-subject.create')->only(['create', 'store']);
        $this->middleware('permission:master-subject.edit')->only(['edit', 'update']);
        $this->middleware('permission:master-subject.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterSubject::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';

                    // ✅ Edit: pakai button + data-attribute (trigger modal)
                    if (auth()->user()->can('master-subject.edit')) {
                        $btn .= '<button type="button" '
                            . 'class="btn btn-warning btn-edit" '
                            . 'data-id="' . $row->id . '" '
                            . 'data-nama="' . e($row->Nama) . '" '
                            . 'data-namatranslate="' . e($row->NamaTranslate ?? '') . '" '
                            . 'title="Edit">'
                            . '<i class="fa fa-edit"></i>'
                            . '</button>';
                    }

                    if (auth()->user()->can('master-subject.delete')) {
                        $btn .= '<button type="button" '
                            . 'class="btn btn-danger btn-delete" '
                            . 'data-id="' . $row->id . '" '
                            . 'data-nama="' . e($row->Nama) . '" '
                            . 'title="Hapus">'
                            . '<i class="fa fa-trash"></i>'
                            . '</button>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.subjek-kontak.index');
    }

    public function create()
    {
        return view('subjek.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'NamaTranslate' => 'nullable|string|max:255',
        ]);

        $validated['UserCreate'] = auth()->user() ? auth()->user()->name : 'system';
        MasterSubject::create($validated);

        return redirect()->route('subjek.index')->with('success', 'Subjek berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subject = MasterSubject::findOrFail($id);

        // ✅ Jika request AJAX, return JSON untuk modal
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $subject->id,
                    'Nama' => $subject->Nama,
                    'NamaTranslate' => $subject->NamaTranslate,
                ],
            ]);
        }

        return view('subjek.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = MasterSubject::findOrFail($id);

        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'NamaTranslate' => 'nullable|string|max:255',
        ]);

        $validated['UserUpdate'] = auth()->user() ? auth()->user()->name : 'system';
        $subject->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Subjek berhasil diperbarui.',
            ]);
        }

        return redirect()->route('subjek.index')->with('success', 'Subjek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subject = MasterSubject::find($id);
        if (!$subject) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        $subject->update(['UserDelete' => auth()->user() ? auth()->user()->name : 'system']);
        $subject->delete();

        return response()->json(['status' => 200, 'message' => 'Subjek berhasil dihapus']);
    }
}
