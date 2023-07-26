<?php

namespace App\Http\Controllers;


use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $data['title'] = 'Kelola Ruangan';
        // Ambil seluruh data ruangan dari Model Room
        $data['rooms'] = Room::all();

        // Redirect ke halaman kelola ruangan
        return view('room.index', $data);
    }

    public function store(Request $request)
    {
        // Insert nama ruangan ke database rooms
        Room::insert($request->name);

        return redirect()->route('room.index')->with('status', 'Berhasil menambah ruangan baru.');
    }

    public function update(Request $request)
    {
        // Update nama ruangan berdasarkan ID
        Room::updateById($request->name, $request->id);

        return redirect()->route('room.index')->with('status', 'Berhasil mengubah nama ruangan.');
    }

    public function destroy($id)
    {
        // Hapus data ruangan
        Room::find($id)->delete();

        return redirect()->route('room.index')->with('status', 'Berhasil menghapus data ruangan.');
    }

    // Method untuk mengaktifkan status ruangan
    public function enable($id)
    {
        $room = Room::find($id);
        $roomName = $room->name;

        // Set status menjadi true
        $room->update([
            'status' => true
        ]);

        return redirect()->route('room.index')->with('status', 'Berhasil mengaktifkan ruangan ' . $roomName . '.');
    }

    // Method untuk menonaktifkan status ruangan
    public function disable($id, Request $request)
    {
        $room = Room::find($id);
        $roomName = $room->name;

        // Set statu menjadi false
        $room->update([
            'status' => false
        ]);

        return redirect()->route('room.index')->with('status', 'Berhasil menonaktifkan ruangan ' . $roomName . '.');
    }
}