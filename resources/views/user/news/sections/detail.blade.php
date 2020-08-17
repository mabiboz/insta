<div class="row">

    <div class="col-xs-12 ">
        @if(!is_null($news->image))
            <img style="max-height: 300px;margin: 3px auto" class="img-responsive img-rounded"
                 src="{{ config("UploadPath.news_image_path").$news->image }}" alt="">
        @endif

        <h3 style="font-weight: bold;color: #19158b;">
            {{ $news->title }}
        </h3>

        <p style="text-align: justify;line-height: 30px">

            {{ $news->content }}
        </p>


    </div>
</div>