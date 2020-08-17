<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';

    protected $fillable =['id'];
    public function city()
    {
        return $this->hasMany(City::class);
    }

    public $timestamps=false;

}
