<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Kelola Ruangan';
        // Ambil seluruh data ruangan dari Model Role
        $data['roles'] = Role::all();

        // Redirect ke halaman kelola ruangan
        return view('role.index', $data);
    }

    public function store(Request $request)
    {
        // Insert nama ruangan ke database role
        Role::insert($request->name);

        return redirect()->route('role.index')->with('status', 'Berhasil menambah ruangan baru.');
    }

    public function update(Request $request)
    {
        // Update nama ruangan berdasarkan ID
        Role::updateById($request->name, $request->id);

        return redirect()->route('role.index')->with('status', 'Berhasil mengubah nama ruangan.');
    }

    public function destroy($id)
    {
        // Hapus data ruangan
        Role::find($id)->delete();

        return redirect()->route('role.index')->with('status', 'Berhasil menghapus data ruangan.');
    }
}