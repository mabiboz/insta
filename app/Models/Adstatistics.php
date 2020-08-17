<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adstatistics extends Model
{
    protected $table="adstatistics";
    protected $guarded=['id'];


    public function pagerequest()
    {
        return $this->belongsTo(PageRequest::class, "pagerequest_id");
    }


}
