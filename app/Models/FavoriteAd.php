<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteAd extends Model
{
    protected $table="ad_favorite";
    protected $guarded =['id'];

    /*relations*/
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    /*end relations*/

    public function getSummaryOfAdContentAttribute()
    {
        $content = explode(' ',$this->ad_content);
        $contentArray = array_slice($content,0,5);
        $summary = implode(" ",$contentArray);
        if(count($content) > 5){
            $summary .= "... ";
        }
        return $summary;
    }
}
