@extends("layouts.admin.admin")
@section('top_css')
    <style>
        span.label {
            cursor: pointer;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" rel="stylesheet"/>
    <style>
        .switch-toggle {
            width: 10em;
        }

        .switch-toggle label:not(.disabled) {
            cursor: pointer;
        }
    </style>

@endsection
@section("top_js")

    <script>

        change_state = function (id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: '<?= url('admin/ad/changestate') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                        newStatus: 2,

                    },

                    success: function (data) {
                    }
                });
        };

        change_state_off = function (id) {
            $("#abortReason").modal("show");

            $("#sendReason").click(function (event) {


                var reason_content = $("#reason_content").val();
                $.ajax(
                    {
                        url: '<?= url('admin/ad/changestate') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            newStatus: 0,
                            reason_content: reason_content,
                        },


                        success: function (data) {
                            $("#abortReason").modal("hide");
                            location.reload();
                        }
                    });
            });
        };

    </script>

@endsection
@section("content")

    @include("admin.ads.sections.modal")

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                 لیست آگهی تایید نشده

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="hidden-phone"><i class="icon-question-sign"></i>عنوان</th>
                        <th class="hidden-phone">تصویر</th>
                        <th><i class=" icon-tags"></i>از طرف</th>
                        <th><i class=" icon-edit"></i>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        <tr>
                           <td>{{$loop->iteration +(( $ads->currentPage() - 1) *   $ads->perPage())}}</td>
                            <td>{{ $ad->content }}</td>
                            <td>
                                   @if(count($ad->images))
                          @if(getMediaAccordingType($ad->images->first()->name) == "image")
                                    <img src="{{  config("UploadPath.ad_image_path"). $ad->images->first()->name }}"
                                         alt="آگهی" height="100" width="100">
                                @else
                                    <video src="{{ config("UploadPath.ad_image_path"). $ad->images->first()->name }}"
                                           controls  height="100" width="100" preload="none"
                                    ></video>
                                @endif
                                   @endif
                            </td>
                            <td>{{ optional(optional($ad->campain)->user)->name }}</td>

                            <td>
                                @include("admin.ads.sections.statusToggle")

                            </td>
                            <td>
                                <!--<a  href="{{ route("admin.ad.delete",$ad) }}"-->
                                <!--    onclick="return confirm('آیا برای حذف مطمئن هستید ؟');"-->
                                <!--    class="btn btn-danger btn-xs"><i class="icon-trash "></i></a>-->
                                -

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $ads->render() }}
            </section>
        </div>
    </div>
@endsection
