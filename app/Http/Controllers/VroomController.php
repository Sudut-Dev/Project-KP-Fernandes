<?php

namespace App\Http\Controllers;

use App\Mail\RoomDisabled;
use App\Mail\RoomEnabled;
use App\Models\Vroom;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VroomController extends Controller
{
    public function index()
    {
        $data['title'] = 'Kelola Virtual Room';
        // Ambil seluruh data ruangan dari Model Room
        $data['vrooms'] = Vroom::all();

        // Redirect ke halaman kelola ruangan
        return view('vroom.index', $data);
    }

    public function store(Request $request)
    {
        // Insert nama ruangan ke database v
        Vroom::insert($request->name, $request->link);

        return redirect()->route('vroom.index')->with('status', 'Berhasil menambah ruangan baru.');
    }

    public function update(Request $request)
    {
        // Update nama ruangan berdasarkan ID
        Vroom::updateById($request->name, $request->link, $request->id);

        return redirect()->route('vroom.index')->with('status', 'Berhasil mengubah nama ruangan.');
    }

    public function destroy($id)
    {
        // Hapus data ruangan
        Vroom::find($id)->delete();

        return redirect()->route('vroom.index')->with('status', 'Berhasil menghapus data ruangan.');
    }

    // Method untuk mengaktifkan status ruangan
    public function enable($id)
    {
        $room = Vroom::find($id);
        $roomName = $room->name;

        // Set status menjadi true
        $room->update([
            'status' => true
        ]);

        // Kirim email ke peminjam bahwa ruangan telah diaktifkan

        return redirect()->route('vroom.index')->with('status', 'Berhasil mengaktifkan ruangan ' . $roomName . '.');
    }

    // Method untuk menonaktifkan status ruangan
    public function disable($id, Request $request)
    {
        $room = Vroom::find($id);
        $roomName = $room->name;

        // Set statu menjadi false
        $room->update([
            'status' => false
        ]);

        // Kirim email ke peminjam bahwa ruangan telah dinonaktifkan

        return redirect()->route('vroom.index')->with('status', 'Berhasil menonaktifkan ruangan ' . $roomName . '.');
    }
}