<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table ="userdetails";
    protected $guarded=['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
