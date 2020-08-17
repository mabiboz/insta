<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentRequest extends Model
{
    protected $table='agentrequest';
    protected $guarded=['id'];

    const  FAILED =0;
    const PENDING =1;
    const ACCEPTED =2;

    /*relations*/
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    
    public function agentLevel()
    {
        return $this->belongsTo(AgentLevel::class,'agentlevel');
    }
    /*end relations*/

    public static function getStatusAgentRequest()
    {
        return [
            self::FAILED => "رد شده",
            self::PENDING => "در انتظار ",
            self::ACCEPTED => "تایید شده",
        ];
    }
}
