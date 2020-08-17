<?php

namespace App\Console\Commands;


use App\Models\Adstatistics;
use Carbon\Carbon;
use Illuminate\Console\Command;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStatistic extends Command  implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     
	protected $signature = 'statistic:update';

	protected $name = 'statistic:update';


	protected $description = "update statistic from Ads";

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
	   

        $statistics = Adstatistics::where('mediaid', '!=', null)->where('endshow', null)->get();

        foreach ($statistics as $st) {

            $mediaid = $st->mediaid;
            // if(is_null($st->pagerequest)){
            //     exit;
            // }
            //   dd($st->pagerequest->statistics);
            
            $page = $st->pagerequest->page;
//            dd($page->pageRequest);
//  if(is_null($page)){
//                 exit;
//             }
            
            //  if(is_null($page->pagedetail)){
            //     exit;
            // }
            $username = $page->pagedetail->username;
            $password = $page->pagedetail->password;
            $token=$page->pagedetail->token;

            $debug = false;
            $truncatedDebug = false;

            \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
            $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
            try {

                $ig->login($username, $password);
                $rankToken = \InstagramAPI\Signatures::generateUUID();



//                $info = $ig->people->getSelfFollowers($rankToken, null,3000);
//                dd($info);




                try{
                    $media = $ig->media->getInfo($mediaid)->getItems()[0];
                }catch (\Exception $exception){
                    $st->update([
                        'endshow'=>Carbon::now(),
                    ]);
                    continue;
                }




                $likecount = $media->getLikeCount();
                $commentcount = $media->getCommentCount();
                $viewcont = is_null($media->getViewCount()) ? 0 : $media->getViewCount();
                $followercount=$ig->business->getStatistics()->getData()->getUser()->getFollowersCount();
                $st->update([
                    'likecount' => $likecount,
                    'commentcount' => $commentcount,
                    'viewcount' => $viewcont,
                    'followers'=>$followercount,
                ]);

//             echo $likecount;
//             echo '/';
            } catch (\Exception $e) {

            }
            
            sleep(5);


        }
        




    }
}
