<?php


Broadcast::channel('newAdChannel.{ad_id}', function ($user, $ad_id) {


    return false;
    if (!$user->is_admin) {
        return false;
    }

    $ad = \App\Models\Ad::find($ad_id);
    if ($ad->status != \App\Models\Ad::OK) {
        return false;
    }


    $pageRequests = $ad->pageRequest;
    $adPagesID = [];
    foreach ($pageRequests as $pageRequest) {
        $adPagesID[] = $pageRequest->page->id;
    }

    $userPagesID = $user->pages()->pluck('id')->toArray();


    $resultArray = array_intersect($adPagesID, $userPagesID);

    if (count($resultArray)) {
        return true;
    }
    return false;

});
