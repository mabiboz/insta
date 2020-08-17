<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageRequest extends Model
{
    protected $table ="pagerequests";
    protected $guarded =['id'];


    const FAILED =0;
    const PENDING =1;
    const ACCEPTED =2;
    const FINISHED =3;
    /*relations*/
    public function ad()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class,'page_id');
    }
    public function statistics()
    {
        return $this->hasOne(Adstatistics::class, "pagerequest_id");
    }
}
