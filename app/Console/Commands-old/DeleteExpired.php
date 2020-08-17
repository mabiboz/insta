<?php

namespace App\Console\Commands;

use App\Appointment;
use App\Models\PageRequest;
use App\Models\User;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpired extends Command
{
	protected $signature = 'expired:delete';

	protected $name = 'expired:delete';


	protected $description = "delete expire request and return mony to user wallet";

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
        $pagereq=PageRequest::where('status',PageRequest::PENDING)->get();
        foreach ($pagereq as $req){
            $ad=$req->ad;
            $userAd=User::find($ad->user_id);
            $dayCount=$ad->day_count;
            $pagePrice=$req->page->price;
            $expireDate=$ad->expired_at;
            $finalPrice=$pagePrice*$dayCount;
            if(Carbon::now()>$expireDate){
                $req->update(['status'=>PageRequest::FAILED]);
                $userAd->wallet->update(['sum'=>  $userAd->wallet->sum+$finalPrice]);
                WalletLog::create([
                    'user_id' => $ad->user_id,
                    'price' => $finalPrice,
                    'method_create' => WalletLog::EXPIRE_AD,
                    'wallet_operation' => WalletLog::INCREMENT,
                ]);

            }



        }
       

	}
}
