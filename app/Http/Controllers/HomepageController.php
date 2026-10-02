<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:homepage.view')->only(['index']);
    }

    public function index()
    {
        return view('pages.admin.manajemen-konten.homepage.index');
    }
}
