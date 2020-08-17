<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campain extends Model
{
    protected $guarded =['id'];
    

    
    /*relations*/
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class)->withPivot("status");
    }

    public function ads()
    {
        return $this->belongsToMany(Ad::class);
    }
}
