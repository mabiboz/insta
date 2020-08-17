<?php

use App\Jdf;



function getUrlContent($url) {
    fopen("cookies.txt", "w");
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Host:adfoc.us',
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);

    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    //$result=str_replace("\n","",$result);
    return $result;
}


function flash_message($message, $type)
{
    session()->flash("flash_message", $message);
    session()->flash("flash_message_type", $type);
}

function checkUserStatus()
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user->status == \App\Models\User::ACTIVE) {
        return true;
    }
    return false;
}

function checkUserVerifiedAndAcceptRule()
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user->verify == \App\Models\User::VERIFIED_AND_ACCEPT_RULE) {
        return true;
    }
    return false;
}

function checkUserVerifiedAndNotAcceptRule()
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user->verify == \App\Models\User::VERIFIED_AND_NOT_ACCEPT_RULE) {
        return true;
    }
    return false;
}


function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}


function createSmsLog($data)
{
    \App\Models\SmsLog::create([
        "type" => $data['type'],
        "msg" => $data['msg'],
        "mobile" => $data['mobile'],
    ]);
}




function acceptagent($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز، درخواست نمایندگی شما در سامانه مابینو تایید گردید به امید موفقیت شما";
    createSmsLog(["type" => \App\Models\SmsLog::ACCEPT_AGENT, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=acceptagent";
    $res = CallAPI("GET", $url);
}


function acceptcampain($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز، کمپین شما با موفقیت تایید شد. برای مشاهده گزارش ها به مابینو مراجعه نمایید";
    createSmsLog(["type" => \App\Models\SmsLog::ACCEPT_CAMPAIN, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=acceptcampain";
    $res = CallAPI("GET", $url);
}



function answerticket($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز،جواب تیکت شما درسامانه مابینو ثبت شد. به مابینو مراجعه نمایید";
    createSmsLog(["type" => \App\Models\SmsLog::ANSWER_TICKET, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=answerticket";
    $res = CallAPI("GET", $url);
}


function getmabinoads($name, $mobile)
{
    $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز، شما یک آگهی مابینویی دریافت کردید.برای پذیرش و انتشار آن به پنل خود مراجعه نمایید.";
    createSmsLog(["type" => \App\Models\SmsLog::GET_AD_MABINOE, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=getmabinoads";
    $res = CallAPI("GET", $url);
}



function connecttomabino($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز، اتصال صفحه اینستاگرام شما با مابینو با موفقیت انجام شد";
    createSmsLog(["type" => \App\Models\SmsLog::CONNECT_TO_MABINO, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=connecttomabino";
    $res = CallAPI("GET", $url);
}


function getad($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . "  عزیز، شما یک آگهی در مابینو دریافت کردید. به مابینو مراجعه نمایید";
    createSmsLog(["type" => \App\Models\SmsLog::GET_AD, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=getad";
    $res = CallAPI("GET", $url);
}


function receiveticket($name, $mobile)
{
        $name = str_replace(" ",".",$name);

    $msg = $name . " عزیز، یک تیکت جدید در مابینو دارید. ";
    createSmsLog(["type" => \App\Models\SmsLog::RECEIVE_TICKET, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$name&template=receiveticket";
    $res = CallAPI("GET", $url);
}



function sendActivationCode($mobile, $code)
{
    
    $msg = " ممنون از ثبت نام شما کد تایید عضویت:  ".$code;
    createSmsLog(["type" => \App\Models\SmsLog::USER_VERIFY, "msg" =>$msg,"mobile"=>$mobile]);
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$code&template=verify";
    $res = CallAPI("GET", $url);
}


function sendResetPasswordVerifyMobile($mobile, $code)
{
    $url = "https://api.kavenegar.com/v1/66314A545A4273464A554A7A624775364638574163485352467358324F6D5463/verify/lookup.json?receptor=$mobile&token=$code&template=ResetpassMobile";
    $res = CallAPI("GET", $url);
}


function getjalaliDate($date)
{
    $jdf = new Jdf();
    $dateArray = $date->format('Y-m-d');
    $dateArray = explode('-', $dateArray);
    $result = $jdf->gregorian_to_jalali($dateArray[0], $dateArray[1], $dateArray[2], '-');
    return persianFormat($result);
}

function persianFormat($value)
{
    $en_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $fa_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str_replace($en_numbers, $fa_numbers, $value);
}

function EnFormat($value)
{
    $en_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $fa_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str_replace($fa_numbers, $en_numbers, $value);
}

function getBankName()
{
//    $banks=  \App\Setting::where('setting_title','LIKE',"%درگاه%")->get();
//    foreach ($banks as $bank){
//        if($bank->setting_value == 1){
//            return $bank->setting_key;
//        }
//    }
//    return "MELLAT";
    //return "ZARINPAL";
    return "PARSIAN";
}

function getPivots($page_id = null, $campain_id = null, $ad_id = null)
{
    if(is_null($page_id)){
        $campain = \App\Models\Campain::find($campain_id);
        $ad = \App\Models\Ad::find($ad_id);

        $ad_pages = $ad->pages;
        $campain_pages = $campain->pages;




    }elseif(is_null($campain_id)){

    }elseif(is_null($ad_id)){

    }else{

    }
}




function getRatio($dayCount){
    
    return \DB::table('ratio_days')->where('day_count', $dayCount)->first()->ratio;
}


function getMediaAccordingType($fileName)
{

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
        return "image";
    } else {
        return "video";
    }


}



function searchItems($fields,$queryBuilder){
    if(\Illuminate\Http\Request::capture()->filled('searchTerm')){
        $searchTerm = \Illuminate\Http\Request::capture()->searchTerm;
        return  $queryBuilder->whereLike(array_wrap($fields), $searchTerm);
    }
    return $queryBuilder;
}