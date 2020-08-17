@extends("layouts.user.user")

@section("content")
    @if(count($news))
        @foreach($news as $item)
            <div class="row">

                <div class="col-xs-12 col-md-6 col-md-offset-3 well">
                    @if(!is_null($item->image))
                        <img style="max-height: 300px;margin: 3px auto" class="img-responsive img-rounded"
                             src="{{ config("UploadPath.news_image_path").$item->image }}" alt="">
                    @endif

                    <h3 style="font-weight: bold;color: #19158b;">
                        {{ $item->title }}
                    </h3>

                    <p style="text-align: justify;line-height: 30px">

                        {{ str_limit($item->content,150) }}
                    </p>

                        <button class="btn btn-primary btn-shadow modalAjax" data-id="{{ $item->id }}" data-url="{{ route('user.news.detail') }}" >
                            <span class="fa fa-eye">ادامه مطلب</span>
                        </button>
                </div>
            </div>
        @endforeach
    @else
        <div class="row">

            <div class="col-xs-12">
                <p class="alert alert-warning text-center">هیچ خبری یافت نشد !</p>
            </div>
        </div>

    @endif

    @include("user.news.sections.modal")

@endsection
