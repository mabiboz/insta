@extends("layouts.admin.admin")

@section("bottom_js")
    <script>
        $("#addNewNews").click(function () {
            $("#newNewsForm").slideToggle(1000);
        });
    </script>
@endsection
@section("content")
    <div class="row" style="margin-bottom: 30px">


        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <button class="btn btn-primary btn-shadow" id="addNewNews"><span class="fa fa-plus-circle"></span>
                اعلان خبر جدید
            </button>
            @include("admin.news.sections.form")
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 well">
            <section class="panel">
                <header class="panel-heading">
                    لیست اخبار
                </header>
                @foreach($news as $item)
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-warning" style="border: 2px inset #c09853">
                                <div class="panel-heading">{{ !is_null($item->title) ?$item->title : "بدون عنوان" }}

                                    <a href="{{ route('admin.news.delete',$item) }}" class="btn btn-danger btn-xs"
                                    onclick="return confirm('آیا از حذف خبر موردنظر مطمئن هستید ؟')"
                                    >
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-9">
                                            <p style="text-align: justify">
                                                {{ $item->content }}
                                            </p>
                                        </div>
                                        <div class="col-xs-12 col-md-3">
                                            @if(!is_null($item->image))
                                                <img width="100" height="100" class="img-circle"
                                                     src="{{ config("UploadPath.news_image_path").$item->image }}"
                                                     alt="">
                                            @else
                                                <span class="badge">بدون تصویر</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        </div>
    </div>
@endsection
