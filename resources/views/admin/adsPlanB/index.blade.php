@extends("layouts.admin.admin")

@section("content")

    @include("admin.ads.sections.modal")
    @include("admin.adsPlanB.sections.modal")

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست آگهی های دستی
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>محتوا آگهی</th>
                        <th>تصویر</th>
                        <th><i class=" icon-tags"></i>از طرف</th>
                        <th>
                            پیج دار
                        </th>
                        <th>
                            آدرس صفحه

                        </th>
                        <th>تعداد روز انتشار
                        </th>
                        <th>

                            بروزرسانی آمار
                            و لینک
                        </th>
                        <th>
                            لینک آگهی
                        </th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($pageRequests as $pageRequest)



                        <tr>

                            <td>{{$loop->iteration}}</td>
                            <td>{{ $pageRequest->ad->content }}</td>

                            <td>

                                @if(count($pageRequest->ad->images))
                                    @if( getMediaAccordingType($pageRequest->ad->images->first()->name) == "image")
                                        <img src="{{  config("UploadPath.ad_image_path"). $pageRequest->ad->images->first()->name }}"
                                             alt="آگهی" height="100" width="100">
                                    @else
                                        <video src="{{ config("UploadPath.ad_image_path"). $pageRequest->ad->images->first()->name }}"
                                               controls height="100" width="100" preload="none"
                                        ></video>
                                    @endif
                                @endif
                            </td>
                            <td>{{ optional(optional($pageRequest->ad->campain)->user)->name }}</td>
                            <td>{{ optional(optional($pageRequest->page)->user)->name }}
                                /
                                {{   optional(optional($pageRequest->page)->user)->mobile  }}
                            </td>

                            <td>
                                <a target="_blank" href="https://www.instagram.com/{{ str_replace("@","",optional($pageRequest->page)->instapage_id) }}">{{ optional($pageRequest->page)->instapage_id }}</a>

                            </td>

                            <td>
                                {{  $pageRequest->ad->day_count }}
                            </td>

                            <td><span class="icon icon-edit modalAjax"  data-url="{{ route('admin.planB.Ad.statisticsEdit') }}" data-id="{{ $pageRequest->id }}"></span></td>

                            <td>
                                @if(!is_null($pageRequest->link))
                                    <a href="{{ $pageRequest->link }}" target="_blank">
                                        <span class="fa fa-link fa-2x"></span>
                                    </a>
                                @else
                                    <span class="badge" style="background-color: red">بدون لینک</span>
                                @endif
                            </td>
                            <td>
                                @if(!is_null($pageRequest->link))

                                    @if($pageRequest->updated_at->addDay($pageRequest->ad->day_count)->lessThan(Carbon\Carbon::now()))
                                        <a href="{{ route('admin.planB.Ad.checkout',['ad'=>$pageRequest->ad->id,'page'=>$pageRequest->page->id]) }}"
                                           onclick="return confirm('آیا تسویه حساب انجام می شود ؟')"
                                           class="btn btn-xs btn-primary"
                                        >تسویه حساب</a>


                                    @else
                                        <span class="badge">
                                            آگهی هنوز به پایان نرسیده است .
                                        </span>
                                    @endif
                                @else
                                    مجاز به تسویه حساب نمی باشید.
                                @endif


                            </td>


                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </section>
        </div>
    </div>
@endsection
