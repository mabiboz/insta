<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
       protected $guarded =['id'];


    protected $dates=['expired_at'];

    const FAILED = 0;
    const PENDING = 1;
    const OK = 2;

    /*relations*/
    public function campains()
    {
        return $this->belongsToMany(Campain::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'ad_id');
    }

    public function reasonAbort()
    {
        return $this->hasOne(ReasonAbort::class, "ad_id");
    }


     public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    public function pageRequest()
    {
        return $this->hasMany(PageRequest::class,'ad_id');
    }

    /*end relations*/

    public function getCampainAttribute()
    {
        return $this->campains()->first();
    }




       public static function notIsExpired($ad)
    {
        if (Carbon::now()->greaterThan($ad->expired_at)) {
            return true;
        }
        return false;
    }

    public static function getAdNotExpired()
    {
        $ads = Ad::where("status", Ad::OK)->get();
        foreach ($ads as $ad) {
            if (!self::notIsExpired($ad)) {
                unset($ad);
            }
        }
        return $ads;
    }


}
