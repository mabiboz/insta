<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayRequest extends Model
{
    protected $table ="payrequest";
    protected $guarded =['id'];

    const PENDING=0;
    const SUCCESS=1;

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }


}
