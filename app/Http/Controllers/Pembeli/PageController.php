<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Katalog;

class PageController extends Controller
{
    public function page_home()
    {
        $banner = Katalog::all();
        $katalog = Katalog::all();
        return view('Pembeli.page_home', compact('banner', 'katalog'));
    }
}
