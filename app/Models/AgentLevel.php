<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentLevel extends Model
{
    
    const INACTIVE = 0;
    const ACTIVE = 1;
    
    
    protected $table="agentlevels";
    protected $guarded =['id'];
}
