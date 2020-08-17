<?php

namespace App\Jobs;

use App\customclass\postToInstagram;
use App\Helper\ProfitSharing;
use App\Models\Profit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Vinkla\Instagram\Instagram;


class SendPostToInstagram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $pageRequest;
    protected $price;
    protected $ad;
    protected $page;

    public $tries = 3;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pageRequest, $price, $ad, $page)
    {
        $this->pageRequest = $pageRequest;
        $this->price = $price;
        $this->ad = $ad;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        set_time_limit(0);
        date_default_timezone_set('UTC');


        $image = $this->pageRequest->ad->images()->first()->name;
        $image = base_path().'/uploads/ads/images/' . $image;
        

      // $photoFilename = str_replace('/', '', $image);
         $photoFilename = $image;
        $captionText = $this->pageRequest->ad->content;


        /////// CONFIG ///////
        $username = $this->pageRequest->page->pagedetail->username;
        $password = $this->pageRequest->page->pagedetail->password;
        $token = $this->pageRequest->page->pagedetail->acceesstoken;


        $debug = false;
        $truncatedDebug = false;

        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

        $ig->login($username, $password);


      //  $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($image);
      //  $media = $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => //$captionText]);
      
      //determinate type of media
      $fileName = $this->ad->images()->first()->name;
        $typeArray = explode('.', $fileName);
       $lastKey = count($typeArray) - 1;
       $fileExtension = $typeArray[$lastKey];

    $typesImage = [
        'jpeg',
        'jpg',
        'png',
        'gif',
    ];


    if (in_array($fileExtension, $typesImage)) {
        $typeMedia = "image";
    } else {
          $typeMedia = "video";
    }
    


      //end determinate

      
          if(  $typeMedia  == "image"){
                    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
                    $media=$ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
                }elseif(  $typeMedia == "video"){
            //   $tumb=base_path().'/mabino/img/avatar1.jpg';
              $cover =  $this->pageRequest->ad->campains()->first()->cover;
              $tumb=config("UploadPath.cover_image_path").$cover;
              $uploadvideo=new postToInstagram();
              $uploadvideo->login($username, $password);

              $uploadvideo->UploadVideo($photoFilename,$tumb,$captionText);

            //   $instagram = new Instagram($token);
            //   $media = $instagram->get();
            //   $idmedia=$media[0]->id;
            
                   $debug = false;
        $truncatedDebug = false;

        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
        
        
         $ig->login($username, $password);
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            
              $idmedia = $ig->timeline->getTimelineFeed()->getFeedItems()[0]->getMediaOrAd()->getId();
              
              $this->pageRequest->statistics->update([
                  "mediaid" => $idmedia,
                  "pk" => $idmedia,

              ]);



                   // $video = new \InstagramAPI\Media\Video\InstagramVideo($photoFilename);
                   // $media=$ig->timeline->uploadVideo($video->getFile(), ['caption' => $captionText]);
                }else{
                    exit;
           }


        if(  $typeMedia  == "image") {
            
            $this->pageRequest->statistics->update([
                "mediaid" => $media->getMedia()->getId(),
                "pk" => $media->getMedia()->getPk(),

            ]);
        }

        $profitForMabino = new ProfitSharing($this->page,$this->ad);
        $profitForMabino->forMabino();


    }
}
