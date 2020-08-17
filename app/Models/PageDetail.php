<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageDetail extends Model
{
    protected $table="pagedetails";
    protected $guarded=['id'];

    public function page()
    {
        return $this->belongsTo(Page::class,'page_id');
    }



    /*mutator and accessor*/
    public function getUsernameAttribute()
    {
        $username = $this->attributes['username'];
        return decrypt($username);
    }


    public function setUsernameAttribute($username)
    {

        $this->attributes['username'] = encrypt($username);

    }

    public function getPasswordAttribute()
    {
        $password = $this->attributes['password'];
        return decrypt($password);

    }


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }


}
