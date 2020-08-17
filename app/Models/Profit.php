<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $guarded=['id'];

    /*relations*/
    public function page()
    {
        return $this->belongsTo(Page::class,'page_id');
    }
    public function ad()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }
    /*end relations*/
}
