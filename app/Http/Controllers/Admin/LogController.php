<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        return view('Admin.log');
    }

    public function get_log()
    {
        $data = Log::select('id_log', 'aktivitas', 'users_id', 'created_at')->with('user')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-ubah" onClick="detail_data(' . "'" . $row->id_log . "'" . ')"><i class="fa-solid fa-eye"></i> Detail</a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detail(Request $request)
    {
        $id = $request->input('q');
        $log = Log::with('user')->find($id);

        return response()->json(['status' => true, 'log' => $log]);
    }
}
