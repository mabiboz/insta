<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = "smslogs";
    protected $guarded =['id'];

    const ACCEPT_AGENT = 1;
    const ACCEPT_CAMPAIN =2;
    const ANSWER_TICKET =3;
    const CONNECT_TO_MABINO =4;
    const GET_AD =5;
    const RECEIVE_TICKET =6;
    const USER_VERIFY =7;
   const GET_AD_MABINOE =8;



}
