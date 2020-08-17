<?php

namespace App\Http\Controllers;

use App\Helper\ProfitSharing;
use App\Models\Adstatistics;
use Illuminate\Http\Request;
use Vinkla\Instagram\Instagram;
use Carbon\Carbon;

class TestController extends Controller
{
    
       public function testcurl(Request $request)
    {
         return $request->all();
    }

    public function getcurl()
    {
        // $post_data=array();
        // $post_data['name'] = 'abbas';
        // $post_data['lname'] = 'kh';

        // $post_items='';
        // foreach ( $post_data as $key => $value) {
        //     $post_items.= $key . '=' . urlencode($value).'&';
        // }
        // $post_items=substr($post_items,0,-1);


        // $curl_connection=curl_init();
        // curl_setopt($curl_connection, CURLOPT_URL,'http://mabino.ir/curl' );

        // curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        // curl_setopt($curl_connection, CURLOPT_POST, true);
        // curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_items);
        // curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($curl_connection);

        // curl_close($curl_connection);
        // print $result;
        //-------------------------------------------------------------------
        $post_data['name'] = 'myemail';
$post_data['lname'] = 'mypassword';

//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {
    $post_items[] = $key . '=' . $value;
}

//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);

//create cURL connection
$curl_connection = 
  curl_init('http://mabino.ir/testcurl');

//set options
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT, 
  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
//perform our request
$result = curl_exec($curl_connection);

print $result;
//show information regarding the request
echo curl_errno($curl_connection) . '-' . 
                curl_error($curl_connection);

//close the connection
curl_close($curl_connection);


    }
    
    public function updatestatistic()
    {
       
        set_time_limit(0);
        date_default_timezone_set('UTC');

 \InstagramAPI\Utils::$ffprobeBin = '/usr/local/bin/ffmpeg';
//  \InstagramAPI\Utils::$ffmpegBin = '/home/mabino/ffmpeg/bin/ffmpeg';
 \InstagramAPI\Utils::$ffprobeBin = '/usr/local/bin/ffprobe'; 
   
        //$image = $this->pageRequest->ad->images()->first()->name;
        $image = base_path().'/uploads/ads/images/ad_1562148557_92.mp4';
        

      // $photoFilename = str_replace('/', '', $image);
         $photoFilename = $image;
        $captionText ='ddddddddddd';


        /////// CONFIG ///////
        $username = "abbasamircocafenew";
        $password = "abbasamir123456";
        $debug = true;
        $truncatedDebug = false;

        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

        $ig->login($username, $password);


      //  $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($image);
      //  $media = $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => //$captionText]);
      
      //determinate type of media
      $fileName = "ad_1562148557_92.mp4";
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
    
    \DB::table('setting')->insert([
        'setting_key'=>$typeMedia,
        'setting_value'=>'ss',
        'setting_title'=>'rr'
        
        ]);

      //end determinate

      
          if(  $typeMedia  == "image"){
                    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
                    $media=$ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
                }elseif(  $typeMedia == "video"){
                    $video = new \InstagramAPI\Media\Video\InstagramVideo($photoFilename);
                    $media=$ig->timeline->uploadVideo($video->getFile(), ['caption' => $captionText]);
                }else{
                    exit;
           }
        
        
        
        // $this->pageRequest->statistics->update([
        //     "mediaid" => $media->getMedia()->getId(),
        //     "pk" => $media->getMedia()->getPk(),

        // // ]);

        // $profitForMabino = new ProfitSharing($this->page,$this->ad);
        // $profitForMabino->forMabino();



    }


    public function autoDeleteMedia()
    {
        
        
          $debug = false;
                $truncatedDebug = false;

                \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
                $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
                
                 $username = 'abbasamircocafenew';
                $password = 'abbasamir123456';
                    $ig->login($username, $password);
                   dd( $ig->timeline->getTimelineFeed());
        
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
                
                 $username = 'abbasamircocafenew';
                $password = 'abbasamir123456';
                    $ig->login($username, $password);
                   dd( $ig->timeline->getTimelineFeed());
                try {

                    $statistic->update([
                        'endshow'=>Carbon::now(),
                        'end_work' => 1
                    ]);
 $username = 'abbasamircocafenew';
                $password = 'abbasamir123456';
                    $ig->login($username, $password);
                    dd('ok');
                   dd( $ig->media->getReelsMediaFeed());

                    $ig->media->delete($mediaid);
                    $profitForPageOwner = new ProfitSharing($page,$ad);
                    $profitForPageOwner->forPageOwner();

                }catch (\Exception $e){
                    echo $e;

                }

            }


        }

    }



}
