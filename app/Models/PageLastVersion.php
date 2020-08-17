<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageLastVersion extends Model
{
    protected $table = "pages_lastversion";
    protected $primaryKey = "id";
    protected $guarded = ['id'];


    public function page()
    {
        return $this->belongsTo(Page::class);
    }

}
