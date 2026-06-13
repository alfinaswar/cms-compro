<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource (DataTables Server-side).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Berita::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Thumbnail', function ($row) {
                    if ($row->PathThumbnail) {
                        return '<img src="' . Storage::url($row->PathThumbnail) . '" style="width:80px;height:50px;object-fit:cover;border-radius:4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    $colors = ['Draf' => 'secondary', 'Diterbitkan' => 'success', 'Arsip' => 'danger'];
                    $color = $colors[$row->Status] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . $row->Status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('berita.edit', $row->Slug) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="' . route('berita.show', $row->Slug) . '" target="_blank" class="btn btn-info" title="Lihat"><i class="fa fa-eye"></i></a>';

                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['Thumbnail', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.berita.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriBerita::orderBy('NamaKategori')->get();
        return view('pages.admin.berita.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|string|max:100',
            'Tags' => 'nullable|string',  // String comma-separated
            'Ringkasan' => 'nullable|string',
            'Konten' => 'required|string',
            'PathThumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',
            // SEO
            'SEOTitle' => 'nullable|string|max:70',
            'SEODescription' => 'nullable|string|max:160',
            'SEOKeywords' => 'nullable|string|max:255',
        ]);

        // Handle Thumbnail Upload
        if ($request->hasFile('PathThumbnail')) {
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }

        // Auto Slug
        $validated['Slug'] = Str::slug($validated['Judul']) . '-' . time();

        // Auto Author
        $validated['Penulis'] = $validated['Penulis'] ?? auth()->user()->name;
        $validated['UserCreate'] = auth()->user()->name;

        // Format Tags: jika array (dari select2) jadi string, jika string biarkan
        if (is_array($validated['Tags'])) {
            $validated['Tags'] = implode(', ', $validated['Tags']);
        }

        $berita = Berita::create($validated);

        // Activity log di sini
        activity()
            ->causedBy(auth()->user())
            ->performedOn($berita)
            ->withProperties(['attributes' => $berita->toArray()])
            ->log('Menambahkan berita baru: ' . $berita->Judul);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::where('Slug', $id)->first();
        $kategoris = KategoriBerita::orderBy('NamaKategori')->get();
        return view('pages.admin.berita.edit', compact('berita', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::where('Slug', $id)->first();

        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|string|max:100',
            'Tags' => 'nullable|string',
            'Ringkasan' => 'nullable|string',
            'Konten' => 'required|string',
            'PathThumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',
            'SEOTitle' => 'nullable|string|max:70',
            'SEODescription' => 'nullable|string|max:160',
            'SEOKeywords' => 'nullable|string|max:255',
        ]);

        // Handle Thumbnail Update
        if ($request->hasFile('PathThumbnail')) {
            if ($berita->PathThumbnail && Storage::disk('public')->exists($berita->PathThumbnail)) {
                Storage::disk('public')->delete($berita->PathThumbnail);
            }
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }

        $validated['Slug'] = Str::slug($validated['Judul']) . '-' . time();
        $validated['UserUpdate'] = auth()->user()->name;

        // Format Tags
        if (is_array($validated['Tags'])) {
            $validated['Tags'] = implode(', ', $validated['Tags']);
        }

        $oldBerita = $berita->replicate();

        $berita->update($validated);

        // Activity log di sini
        activity()
            ->causedBy(auth()->user())
            ->performedOn($berita)
            ->withProperties([
                'attributes' => $berita->toArray(),
                'old' => $oldBerita->toArray(),
            ])
            ->log('Memperbarui berita: ' . $berita->Judul);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Display the specified resource (Public View).
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);
        if (!$berita) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file fisik
        if ($berita->PathThumbnail && Storage::disk('public')->exists($berita->PathThumbnail)) {
            Storage::disk('public')->delete($berita->PathThumbnail);
        }

        $berita->update(['UserDelete' => auth()->user()->name]);
        $berita->delete();  // Soft delete

        return response()->json(['status' => 200, 'message' => 'Berita berhasil dihapus']);
    }

    /**
     * Upload image for Summernote (AJAX).
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('berita/content', 'public');
            return response()->json(['url' => Storage::url($path)]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }

    public function storeKategoriAjax(Request $request)
    {
        // dd($request->all());

        $kategori = KategoriBerita::create([
            'NamaKategori' => $request->NamaKategori,
        ]);

        return response()->json([
            'status' => 200,
            'message' => "Kategori \"{$kategori->NamaKategori}\" berhasil ditambahkan.",
            'data' => $kategori,
        ]);
    }

    public function news(Request $request)
    {
        $query = Berita::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query
                ->where('Judul', 'like', '%' . $request->search . '%')
                ->orWhere('Ringkasan', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('Kategori', $request->kategori);
        }
        if ($request->filled('tag')) {
            $query->where('Tags', 'like', '%' . $request->tag . '%');
        }
        $news = $query->latest()->paginate(10);
        $recentNews = Berita::latest()->take(3)->get();

        $categories = Berita::select('Kategori')->distinct()->pluck('Kategori');

        return view('frontend.news', compact('news', 'recentNews', 'categories'));
    }

    public function newsDetail($slug)
    {
        $news = Berita::where('Slug', $slug)->firstOrFail();

        $recentNews = Berita::where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();
        $categories = Berita::select('Kategori')->distinct()->pluck('Kategori');
        $prevPost = Berita::where('TanggalPublikasi', '<', $news->TanggalPublikasi)
            ->latest('TanggalPublikasi')
            ->first();
        $nextPost = Berita::where('TanggalPublikasi', '>', $news->TanggalPublikasi)
            ->oldest('TanggalPublikasi')
            ->first();
        $relatedPosts = Berita::where('Kategori', $news->Kategori)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.news-detail', compact(
            'news',
            'recentNews',
            'categories',
            'prevPost',
            'nextPost',
            'relatedPosts'
        ));
    }
}
