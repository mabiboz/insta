<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPage extends Model
{
    protected $table = "categorypage";
    protected $guarded =['id'];

    /*relations*/
    public function pages()
    {
        return $this->hasMany(Page::class,'categorypage_id');
    }
    /*end relations*/
}
