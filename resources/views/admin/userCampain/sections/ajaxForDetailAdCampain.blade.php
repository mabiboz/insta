<div class="row">
    <div class="col-md-12 text-center">
        <p>
            : تعداد روز انتشار
            {{ $ad->day_count }}
        </p>
    </div>
    <div class="col-md-12 text-center">
        @if(getMediaAccordingType($ad->images->first()->name) == "image")
            <img src="{{ config('UploadPath.ad_image_path').$ad->images->first()->name  }}"
                 alt="" height="200" width="300"
                 class="img-circle img-responsive img-thumbnail">
        @else
            <video src="{{ config('UploadPath.ad_image_path').$ad->images->first()->name  }}"
                   controls height="200" width="300" preload="none"
            ></video>
        @endif
    </div>


    <div class="col-md-12 text-center well text-justify">
        {{ $ad->content }}
    </div>

    <div class="col-md-12  ">
        تاریخ انقضا :
        {{ Morilog\Jalali\Jalalian::forge($ad->expired_at)->format("Y/m/d") }}

    </div>


</div>