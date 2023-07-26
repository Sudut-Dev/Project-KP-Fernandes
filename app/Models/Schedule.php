<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_PENDING = 1;
    const STATUS_ACTIVE  = 2;
    const STATUS_DECLINE = 3;
    const STATUS_FINISH = 4;

    public $timestamps = false;

    //  =================================================================

    public static function getById($id)
    {
        return self
            ::where('id', $id)
            ->get();
    }

    public static function getPending()
    {
        return self
            ::whereDate('date', '>=', now()->format('Y-m-d'))
            ->where('status', self::STATUS_PENDING)
            ->get();
    }

    public static function getAlmostStarted($diff)
    {
        $date = now()->format('Y-m-d');
        $then = Carbon::make(now()->format('H:i'))->addMinute($diff)->format('H:i:s');

        return self
            ::whereDate('date', $date)
            ->where('start', $then)
            ->where('status', self::STATUS_ACTIVE)
            ->get('id');
    }

    public static function getFinished()
    {
        // Ambil jadwal yang date & end <= now
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $activeSchedules = self::where('status', self::STATUS_ACTIVE)->get();

        foreach ($activeSchedules as $active) {
            $endDate = Carbon::make($active->date . ' ' . $active->end)->format('Y-m-d H:i:s');

            //Ambil ID jika jadwal sudah berakhir
            if ($now >= $endDate) {
                $ids[] = $active->id;
            }
        }

        return $ids;
    }

    public static function getExpired()
    {
        $expiredSchedules = self
            ::where('status', self::STATUS_PENDING)
            ->orWhere('status', self::STATUS_DECLINE)
            ->get();

        foreach ($expiredSchedules as $exp) {
            $expDate = Carbon::make($exp->date . ' ' . $exp->start)->format('Y-m-d H:i:s');
            $now = now()->format('Y-m-d H:i:s');

            if ($expDate < $now) {
                $newExpiredSchedules[] = $exp;
            }
        }

        return $newExpiredSchedules;
    }

    public static function getActive()
    {
        return self
            ::whereDate('date', '>=', now()->format('Y-m-d'))
            ->where('status', self::STATUS_ACTIVE)
            ->get();
    }

    public static function getActiveByDate($date)
    {
        $date = Carbon::make($date)->format('Y-m-d');

        return self
            ::whereDate('date', $date)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('start', 'asc')
            ->get();
    }

    public static function getActiveByBorrowerId($id)
    {
        return self
            ::where('user_borrower_id', $id)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('date', 'asc')
            ->orderBy('start', 'asc')
            ->get();
    }

    public static function getActiveByRoomId($id)
    {
        return self
            ::where('room_id', $id)
            ->where('status', self::STATUS_ACTIVE)
            ->get();
    }


    public static function getRunningByUserId($id)
    {
        return self
            ::where('user_borrower_id', $id)
            ->where('status', '!=', self::STATUS_FINISH)
            ->get();
    }

    public static function getPendingByBorrowerId($id)
    {
        return self
            ::where('user_borrower_id', $id)
            ->where('status', self::STATUS_PENDING)
            ->orWhere('status', self::STATUS_DECLINE)
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function getFinishByBorrowerId($id)
    {
        return self
            ::where('user_borrower_id', $id)
            ->where('status', self::STATUS_FINISH)
            ->orderBy('date', 'desc')
            ->orderBy('start', 'desc')
            ->get();
    }

    public static function getByBorrowerId($id)
    {
        return self
            ::where('user_borrower_id', $id)
            ->orderByDesc('id')
            ->get();
    }

    public static function getByOfficerId($id)
    {
        return self
            ::where('user_officer_id', $id)
            ->orderByDesc('id')
            ->get();
    }

    public static function getByDate($date)
    {
        return self
            ::whereDate('date', $date)
            ->orderBy('start', 'asc')
            ->get();
    }

    public static function getInMonthDashboard($dates)
    {
        foreach ($dates as $date) {
            $schedules = self
                ::whereDate('date', $date)
                ->orderBy('start', 'asc')
                ->get();

            $data[] = $schedules;
        }

        return $data;
    }

    public static function getInMonth($dates)
    {
        foreach ($dates as $date) {
            $schedules = self
                ::whereDate('date', $date)
                ->where([
                    ['status', '!=', self::STATUS_DECLINE],
                    ['status', '!=', self::STATUS_FINISH]
                ])
                ->orderBy('start', 'asc')
                ->get();

            // Cek ketersediaan data
            if (count($schedules) > 0) {
                // Hanya ambil jadwal yang akan datang
                if ($schedules[0]['date'] >= now()->format('Y-m-d')) {
                    $data[] = $schedules;
                } else {
                    $data[] = [];
                }
            } else {
                $data[] = [];
            }
        }

        return $data;
    }

    public static function setActive($id)
    {
        $schedule = self::find($id);

        $schedule->update([
            'status' => self::STATUS_ACTIVE,
            'approved_at' => now()->format('Y-m-d H:i:s'),
        ]);

        return $schedule->description;
    }

    public static function setDecline($id)
    {
        $schedule = self::find($id);

        $schedule->update([
            'status' => self::STATUS_DECLINE
        ]);

        return $schedule->description;
    }

    public static function setFinish($id)
    {
        $schedule = self::find($id);

        $schedule->update([
            'status' => self::STATUS_FINISH
        ]);

        return $schedule->description;
    }

    // Fungsi untuk cek ketersediaan jadwal
    public static function check($date, $start, $end, $id = null)
    {
        $activeSchedules = null;

        if (!is_null($id)) {
            // Ambil jadwal kecuali id yang diterima
            $activeSchedules = self
                ::whereDate('date', $date)
                ->where('status', self::STATUS_ACTIVE)
                ->where('id', '!=', $id)
                ->orderBy('start', 'asc')
                ->get();
        } else {
            $activeSchedules =
                self
                ::whereDate('date', $date)
                ->where('status', self::STATUS_ACTIVE)
                ->orderBy('start', 'asc')
                ->get();
        }

        $start = Carbon::make($start)->toTimeString();
        $end = Carbon::make($end)->toTimeString();
        $rules = true;

        foreach ($activeSchedules as $active) {
            if ($start < $active->start) {
                $rules =
                    ($active->start >= $start) &&
                    ($active->start < $end)
                    ||
                    ($active->end >= $start) &&
                    ($active->end <= $end);
            } else if ($start >= $active->start) {
                $rules =
                    ($start >= $active->start) &&
                    ($start < $active->end)
                    ||
                    ($end >= $active->start) &&
                    ($end <= $active->end);
            }

            // Jika jadwal sudah terdaftar, return false
            if ($rules) {
                return false;
            } else {
                return true;
            }
        }

        return true;
    }

//     public static function insert($data)
// {
//     $rooms = $data['room'];
//     $vrooms = $data['vroom'];

//     // Make sure the number of rooms and vrooms selected is the same
//     if (count($rooms) !== count($vrooms)) {
//         throw new Exception('Jumlah ruangan dan vroom tidak sesuai.');
//     }

//     foreach ($rooms as $index => $room) {
//         $vroom = $vrooms[$index];

//         self::create([
//             'date' => Carbon::make($data['date'])->format('Y-m-d'),
//             'start' => $data['start'],
//             'end' => $data['end'],
//             'description' => $data['description'],
//             'user_borrower_id' => $data['user'],
//             'room_id' => $room,
//             'vroom_id' => $vroom,
//             'status' => self::STATUS_ACTIVE,
//             'created_at' => now()->format('Y-m-d H:i:s.u0')
//         ]);
//     }
// }

//menggunakan metode belongsToMany pada relasi rooms() untuk menghubungkan Schedule dengan Room melalui tabel pivot schedule_room_vroom.
public static function insert($data)
{
    $schedule = self::firstOrCreate([
        'date' => Carbon::make($data['date'])->format('Y-m-d'),
        'start' => $data['start'],
        'end' => $data['end'],
        'description' => $data['description'],
        'user_borrower_id' => $data['user'],
        'status' => self::STATUS_ACTIVE,
        'created_at' => now()->format('Y-m-d H:i:s.u')
    ]);

    $rooms = $data['room'];
    $vrooms = $data['vroom'];

    foreach ($rooms as $room) {
        $schedule->rooms()->attach($room, ['room_id' => $room]);
    }

    foreach ($vrooms as $vroom) {
        $schedule->vrooms()->attach($vroom, ['vroom_id' => $vroom]);
    }
}


// public static function insert($data)
// {
//     $rooms = $data['room'] ?? [];
//     $vrooms = $data['vroom'] ?? [];

//     // Make sure the number of rooms and vrooms selected is the same
//     if (count($rooms) !== count($vrooms)) {
//         throw new Exception('Jumlah ruangan dan vroom tidak sesuai.');
//     }

//     $bookings = [];

//     foreach ($rooms as $index => $room) {
//         $vroom = $vrooms[$index] ?? null;

//         $booking = [
//             'date' => Carbon::make($data['date'])->format('Y-m-d'),
//             'start' => $data['start'],
//             'end' => $data['end'],
//             'description' => $data['description'],
//             'user_borrower_id' => $data['user'],
//             'room_id' => $room,
//             'vroom_id' => $vroom,
//             'status' => self::STATUS_ACTIVE,
//             'created_at' => now()->format('Y-m-d H:i:s.u0')
//         ];

//         $bookings[] = $booking;
//     }

//     self::insert($bookings);
// }


//     $rooms = $data['room'];
//     $vrooms = $data['vroom'];

//     $roomVroomData = [];
//     foreach ($rooms as $index => $room) {
//         $vroom = $vrooms[$index];
//         $roomVroomData[] = [
//             'room_id' => $room,
//             'vroom_id' => $vroom,
//         ];
//     }

//     $schedule->rooms()->attach($roomVroomData);
// }

// public function rooms()
// {
//     return $this->belongsToMany(Room::class, 'schedule_room_vroom', 'schedule_id', 'room_id')
//                 ->withPivot('vroom_id');
// }

// public static function insert($data)
//     {
//         self
//             ::create([
//                 'date' => Carbon::make($data['date'])->format('Y-m-d'),
//                 'start' => $data['start'],
//                 'end' => $data['end'],
//                 'description' => $data['description'],
//                 'user_borrower_id' => $data['user'],
//                 'room_id' => $data['room'],
//                 'vroom_id' => $data['vroom'],
//                 'status' => self::STATUS_ACTIVE,
//                 'created_at' => now()->format('Y-m-d H:i:s.u0')
//             ]);
//     }

    public static function insertRequest($data)
    {
        self
            ::create([
                'date' => Carbon::make($data['date'])->format('Y-m-d'),
                'start' => $data['start'],
                'end' => $data['end'],
                'description' => $data['description'],
                'user_borrower_id' => auth()->user()->id,
                'room_id' => $data['room'],
                'status' => self::STATUS_PENDING,
                'requested_at' => now()->format('Y-m-d H:i:s.u0')
            ]);
    }

    public static function updateRequest($data, $id)
    {
        self
            ::where('id', $id)
            ->update([
                'date' => Carbon::make($data['date'])->format('Y-m-d'),
                'start' => $data['start'],
                'end' => $data['end'],
                'status' => self::STATUS_ACTIVE,
                'room_id' => $data['room'],
                'vroom_id' => $data['vroom'],
                'description' => $data['description'],
                'user_borrower_id' => $data['user'],
                'updated_at' => now()->format('Y-m-d H:i:s.u0')
            ]);
    }

    public static function updateById($data, $id)
{
    $schedule = self::findOrFail($id);

    $schedule->update([
        'date' => Carbon::make($data['date'])->format('Y-m-d'),
        'start' => $data['start'],
        'end' => $data['end'],
        'status' => $data['status'],
        'description' => $data['description'],
        'user_borrower_id' => $data['user'],
        'updated_at' => now()->format('Y-m-d H:i:s.u')
    ]);

    $rooms = $data['room'];
    $vrooms = $data['vroom'];

    $schedule->rooms()->sync($rooms);
    $schedule->vrooms()->sync($vrooms);
}

    public static function deleteById($id)
    {
        self
            ::where('id', $id)
            ->delete();

        // Hapus notulen dari schedule
    }

    public static function deleteRunningByUserId($id)
    {
        self
            ::where('user_borrower_id', $id)
            ->where('status', '!=', self::STATUS_FINISH)
            ->delete();
    }

    public static function search($data)
{
    return self::where(function ($query) use ($data) {
            $query->where('description', 'like', '%' . $data . '%')
                ->orWhere('vroom_id', 'like', '%' . $data . '%')
                ->orWhere('start', 'like', '%' . $data . '%')
                ->orWhere('end', 'like', '%' . $data . '%')
                ->orWhere('date', 'like', '%' . $data . '%')
                ->orWhere('user_borrower_id', 'like', '%' . $data . '%')
                ->orWhere('room_id', 'like', '%' . $data . '%');
        })
        ->orderByDesc('id')
        ->get();
}


    //  =================================================================

    // Relasi dengan User - Peminjam
    public function borrower()
    {
        return $this->belongsTo(User::class, 'user_borrower_id', 'id');
    }

    // Relasi dengan Note
    public function note()
    {
        return $this->hasOne(Note::class, 'schedule_id', 'id');
    }

    // Relasi dengan Room
    // public function room()
    // {
    //     return $this->hasOne(Room::class, 'id', 'room_id');
    // }

     public function rooms()
    {
        return $this->belongsToMany(Room::class, 'schedule_room', 'schedule_id', 'room_id');
    }

    public function vrooms()
    {
        return $this->belongsToMany(Vroom::class, 'schedule_vroom', 'schedule_id', 'vroom_id');
    }

    // public function vroom()
    // {
    //     return $this->hasOne(Vroom::class, 'id', 'vroom_id');
    // }

}