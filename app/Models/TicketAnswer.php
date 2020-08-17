<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    protected $table="ticketanswers";
    protected $guarded =['id'];
    
    /*relations*/
    public function user()// who write answer
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function ticketMessaging()
    {
        return $this->belongsTo(TicketMessaging::class,"ticket_id");
    }

    /*end relations*/
}
