@extends("layouts.user.user")


@section("content")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست آگهی های من
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان کمپین</th>
                        <th>تعداد روز انتشار</th>
                        <th>محتوا متنی</th>
                        <th>رسانه تصویری</th>
                        <th>تاریخ انقضا</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pageRequests as $pageRequest)
                        @foreach($pageRequest as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->ad->campain->title }}</td>
                                <td>{{ $item->ad->day_count }}</td>
                                <td>{{ $item->ad->content }}</td>
                                <td>
                                    @if(getMediaAccordingType($item->ad->images->first()->name) == "image")
                                        <img src="{{ config('UploadPath.ad_image_path').$item->ad->images->first()->name  }}"
                                             alt="" height="100" width="150"
                                             class="img-circle img-responsive img-thumbnail">
                                    @else
                                        <video src="{{ config('UploadPath.ad_image_path').$item->ad->images->first()->name  }}"
                                               controls height="100" width="100" preload="none"
                                        ></video>
                                    @endif
                                </td>
                                <td>
                                    {{ Morilog\Jalali\Jalalian::forge($item->ad->expired_at)->format("Y/m/d") }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
