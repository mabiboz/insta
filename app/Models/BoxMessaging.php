<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxMessaging extends Model
{
    const CLOSED = 0;
    const OPEN = 1;

    protected $table = "boxmessagings";
    protected $guarded = ['id'];


    /*relations*/
    public function ticketMessagings()
    {
        return $this->hasMany(TicketMessaging::class,"box_id");
    }
    /*end relations*/


}
