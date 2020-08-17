<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonAbort extends Model
{
    const ABORT = 0;
    const VERIFIED = 1;
    protected $table = "reasonabort";
    protected $guarded = ['id'];

    /*relations*/
    public function ad()
    {
        return $this->belongsTo(Ad::class, "ad_id");
    }
}
