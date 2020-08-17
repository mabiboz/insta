@extends("layouts.admin.admin")

@section("content")

    @include("admin.ads.sections.modal")
    @include("admin.adsPlanB.sections.modal")

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست آگهی های دستی تسویه شده
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
                            مبلغ آگهی
                        </th>
                        <th>
                            مبلغ تسویه شده
                        </th>
                        <th>
                            تاریخ تسویه
                        </th>

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

                            <td>
                                {{  $pageRequest->page->price }}
                            </td>

                            <td>
                                @if($pageRequest->ad->is_mabinoe)
                                    @if ($pageRequest->page->reagent)

                                        {{ number_format( $pageRequest->page->reagentLevel->pageowner_percent / 100*$page->price/2)}}


                                    @else

                                        {{number_format($pageRequest->page->price*config("SharingConfig.PERCENT_OF_PAGE_OWNER")/2)}}
                                    @endif
                                @else
                                    @if ($pageRequest->page->reagent)

                                        {{ number_format( $pageRequest->page->reagentLevel->pageowner_percent / 100*$pageRequest->page->price)}}


                                    @else

                                        {{number_format($pageRequest->page->price*config("SharingConfig.PERCENT_OF_PAGE_OWNER"))}}
                                    @endif

                                @endif

                            </td>

                            <td>
                                {{ jdate($pageRequest->updated_at)->format("Y-m-d H:i") }}
                            </td>

                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </section>
        </div>
    </div>
@endsection
