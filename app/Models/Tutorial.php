<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $table = "tutorials";
    protected $guarded = ['id'];

    const ADMIN = 1;
    const USER = 2;
    const AGENT = 3;

    public static function getLevelTutorials()
    {
        return [
            self::ADMIN => "آموزش پیج دارها",
            self::USER => "آموزش کمپین",
            self::AGENT => "آموزش نمایندگان",
        ];
    }
}
