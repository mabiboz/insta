<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table ='city';


    /*relations*/
    public function province()
    {
        return $this->belongsTo(Province::class);

    }

    public function pages()
    {
        return $this->hasMany(Page::class,"city_id");
    }





}
