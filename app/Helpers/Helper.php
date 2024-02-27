<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

function set_active($route)
{
    if (Route::is($route)) {
        return 'active';
    }
}

function aktivitas($aksi)
{
    $log = new Log();
    $log->aktivitas = $aksi;
    $log->user = Auth::user()->username;
    $log->save();
}
