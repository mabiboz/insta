<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessaging extends Model
{
    protected $table = "ticketmessaging";


    const PENDING = 0;
    const ANSWERED = 1;

    protected $guarded = ['id'];

    /*relations*/
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function ticketAnswers()
    {
        return $this->hasMany(TicketAnswer::class, "ticket_id");
    }

    public function boxMessaging()
    {
        return $this->belongsTo(BoxMessaging::class,"box_id");
    }

    /*end relations*/

    public static function getStatusTickets()
    {
        return [
            self::PENDING => 'در انتظار پاسخ',
            self::ANSWERED => 'پاسخ داده شده',
        ];
    }





}
