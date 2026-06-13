<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ActivityLog::with(['causer', 'subject'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('waktu', function ($row) {
                    return $row->created_at->format('d M Y, H:i:s');
                })
                ->addColumn('deskripsi', function ($row) {
                    $badgeClass = match ($row->description) {
                        'created' => 'badge-success',
                        'updated' => 'badge-warning',
                        'deleted' => 'badge-danger',
                        default => 'badge-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->description) . '</span>';
                })
                ->addColumn('pengguna', function ($row) {
                    if ($row->causer) {
                        return '<i class="fa fa-user mr-1"></i> ' . $row->causer->name;
                    }
                    return '<span class="text-muted"><i class="fa fa-cog mr-1"></i> Sistem</span>';
                })
                ->addColumn('model', function ($row) {
                    if ($row->subject) {
                        return '<code>' . class_basename($row->subject_type) . ' #' . $row->subject_id . '</code>';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $properties = htmlspecialchars(json_encode($row->properties));
                    return '<button class="btn btn-info btn-sm btn-detail" data-properties=\'' . $properties . '\' title="Lihat Detail"><i class="fa fa-eye"></i></button>';
                })
                ->rawColumns(['deskripsi', 'pengguna', 'model', 'action'])
                ->make(true);
        }

        return view('pages.admin.activity-logs.index');
    }
}
