<?php

namespace App\Console\Commands;


use App\Helper\ProfitSharing;
use App\Models\Adstatistics;
use Carbon\Carbon;
use Illuminate\Console\Command;

class autoDeleteAd extends Command
{
	protected $signature = 'ad:delete';

	protected $name = 'ad:delete';


	protected $description = "auto delete ad";

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
	    
        
        $statistics = Adstatistics::where('mediaid', '!=', null)->where('endshow',null)->get();

        foreach ($statistics as $statistic) {
            $startTimeToShare = $statistic->created_at;
            $dayCount=$statistic->pagerequest->ad->day_count;
            $endTimeToShare = $statistic->created_at->addDays($dayCount);
            if(Carbon::now()->greaterThan($endTimeToShare)){

                $mediaid = $statistic->mediaid;
                $page = $statistic->pagerequest->page;
                $ad = $statistic->pagerequest->ad;
                $username = $page->pagedetail->username;
                $password = $page->pagedetail->password;
                $token=$page->pagedetail->token;

                $debug = false;
                $truncatedDebug = false;

                \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
                $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
                try {

                    $statistic->update([
                        'endshow'=>Carbon::now(),
                        'end_work' => 1
                    ]);

                    $ig->login($username, $password);

                    $ig->media->delete($mediaid);
                    $profitSharing = new ProfitSharing($page,$ad);
                    $profitSharing->forPageOwner();
                     $profitSharing->forReagent();

                }catch (\Exception $e){
                 

                }

            }


        }

    }
}
