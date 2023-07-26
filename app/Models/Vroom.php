<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vroom extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public static function insert($name, $link)
    {
        self::create([
            'name' => $name,
            'status' => 1
        ]);
    }

    public static function updateById($name, $link, $id)
    {
        self
            ::find($id)
            ->update([
                'name' => $name,
            ]);
    }

}