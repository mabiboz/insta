<div class="row">
    <div class="col-md-12 text-center">
        <p>
            این آگهی برای صفحه
            {{ $page->name }}
            می باشد .
        </p>
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
        
        <a href="{{ route('user.ad.file.download',$ad->images->first()->name) }}" class="btn btn-primary btn-xs">دانلود فایل آگهی</a>
    </div>
    
    <div class="col-md-12 text-center well text-justify" id="textAd">
        {{ $ad->content }}
    </div>
              <button id="copyTextAd" title="copy" class="btn btn-success btn-xs">
                                <span class="fa fa-copy"></span>
                                کپی متن آگهی
                            </button>
                            <p class="badge" id="flash" style="display: none">متن آگهی کپی شد !</p>


    <div class="col-md-12  ">
       تاریخ انقضا :
             {{ Morilog\Jalali\Jalalian::forge($ad->expired_at)->format("Y/m/d") }}

    </div>


</div>

<script>


        $("#copyTextAd").click(function () {
            
            var $temp = $("<textarea>");
            $("body").append($temp);
            $temp.val($("#textAd").text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('#flash').delay(500).fadeIn('normal', function () {
                $(this).delay(2500).fadeOut();
            });
        });
    </script>