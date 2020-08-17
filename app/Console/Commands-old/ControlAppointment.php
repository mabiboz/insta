<?php

namespace App\Console\Commands;

//use App\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ControlAppointment extends Command
{

    protected $signature = 'appointment:delete';
    
     protected $name = 'appointment:delete';


    protected $description = "this is delete Rezerv appoint if it is not confirm";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::first();
        $user->delete();
        

//         if (count($appoints)){
// 			$current_time = \Carbon\Carbon::now()->timestamp;
// 			foreach ($appoints as $appoint){
// 				$appoint_time = $appoint->created_at->timestamp;
// 				$sub_time = $current_time - $appoint_time;
// 				if ($sub_time > 900){ // رب ساعت
// 					$appoint->delete();
// 				}
// 			}
// 		}
// 		else{
//         	return;
// 		}

    }
}
