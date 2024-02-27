<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        return view('Admin.log');
    }

    public function get_log()
    {
        $data = Log::select('id_logs', 'aktivitas', 'user', 'created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
