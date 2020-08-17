@extends("layouts.user.user")
@section("bottom_js")

    <script>
        $(".changeStateAdRequest").click(function (event) {
            event.preventDefault();
            var id = $(this).data("id");
            var state = $(this).data("state");
            var pageid = $(this).data("pageid");

            $.ajax({
                type: "POST",
                url: "{{ route('user.requestAd.changeState') }}",
                data: {
                    id: id,
                    state: state,
                    pageid: pageid,
                },
                success: function (response) {
                    // alert('ok');
                    location.reload();
                }

            });
        });
    </script>
@endsection

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست آگهی های دستی
                </header>

                <table class="table table-bordered text-center table-hover">
                    <tr class="text-center">
                        <th>#</th>
                        <th>عنوان</th>
                        <th>جزئیات آگهی</th>
                        <th>عملیات</th>
                        <th>لینک</th>
                    </tr>
                    @foreach($adsArray as $page_id=>$ads)
                        @foreach($ads as $ad)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ad->campain->title }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs modalAjaxRequest "
                                            data-url="{{ route('user.requestAd.showDetails') }}"
                                            data-id="{{ $ad->id }}"
                                            data-pageid="{{ $page_id }}">جزئیات
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if($ad->pageRequest()->where("page_id",$page_id)->latest()->first()->status == \App\Models\PageRequest::PENDING)
                                            <button class="btn btn-success btn-xs pull-left changeStateAdRequest"
                                                    data-state="2" data-id="{{ $ad->id  }}"
                                                    data-pageid="{{ $page_id }}">
                                                تایید
                                            </button>
                                            <button class="btn btn-danger btn-xs changeStateAdRequest"
                                                    data-state="0"
                                                    data-id="{{ $ad->id  }}"
                                                    data-pageid="{{ $page_id }}">عدم تایید
                                            </button>

                                        @elseif($ad->pageRequest()->where("page_id",$page_id)->latest()->first()->status == \App\Models\PageRequest::ACCEPTED)
                                            <span class="badge"
                                                  style="background-color: green"> تایید شده توسط شما</span>
                                            @if(!is_null($ad->pageRequest()->where("page_id",$page_id)->latest()->first()->link))
                                                <span class="badge" style="background-color: #1c94c4">لینک وارد شده</span>
                                            @else
                                                <span class="badge" style="background-color: #d43f3a">منتظر ثبت لینک</span>

                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('user.planB.ad.registerLink') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="page_id" value="{{ $page_id }}">
                                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                                        <input type="text" name="link" required class="form-control"
                                               placeholder="پس از انتشار آگهی در پیج خود ، لینک آگهی را در این قسمت وارد نمایید"
                                               value="{{ $ad->pageRequest()->where("page_id",$page_id)->latest()->first()->link }}">
                                        <button type="submit" class="btn btn-xs btn-default btn-shadow">ثبت لینک
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>

            </section>
        </div>
    </div>
@endsection
