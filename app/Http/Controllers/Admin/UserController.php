<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('Admin.user');
    }

    public function get_user(Request $request)
    {
        $data = User::select('id', 'username', 'email', 'role')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:' . User::class,
            'email' => 'required|string|email|unique:' . User::class . '|max:100',
            'password' => 'required|min:8|unique:' . User::class,
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Plat Nomor wajib diisi.',
            'email.unique' => 'Plat Nomor ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.unique' => 'Password sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            echo json_encode(['status' => TRUE]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $user = User::find($id);

        echo json_encode(['status' => TRUE, 'isi' => $user]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'nullable|min:8',
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Plat Nomor wajib diisi.',
            'email.unique' => 'Plat Nomor ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'password.unique' => 'Password sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;

            $user->save();

            echo json_encode(['status' => TRUE]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $katalog = User::find($id);
        $katalog->delete();

        echo json_encode(['status' => TRUE]);
    }
}
