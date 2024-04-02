<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function page_profile()
    {
        return view('Pembeli.page_profile');
    }
}
