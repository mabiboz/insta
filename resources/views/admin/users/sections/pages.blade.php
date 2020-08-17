
@include("admin.pages.sections.modal")
@include("admin.pages.sections.modalAbortPage")
@include("admin.pages.sections.modalAjax")

<table class="table table-striped table-advance table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th><i class="icon-question-sign"></i>عنوان</th>
        <th><i class=" icon-tags"></i>آدرس صفحه</th>
        <th><i class=" icon-user"></i>صاحب پیج</th>
        <th><i class="icon-bookmark"></i>دسته بندی</th>

        <th>قیمت پیشنهادی
            <span style="font-size:10px">(تومان)</span>
        </th>
        <th>قیمت
            <span style="font-size:10px">(تومان)</span>
        </th>

        <th> وضعیت کنونی</th>
        <th>نوع انتشار</th>

        <th><i class=" icon-edit"></i>تغییر وضعیت</th>
        <th>مشاهده جزئیات</th>
        <th>عملیات</th>
        <th>تاریخ ایجاد</th>


    </tr>
    </thead>
    <tbody>
    @foreach($pages as $page)
        <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{ $page->name }}</td>
            <td>
                <a target="_blank"
                   href="https://www.instagram.com/{{ str_replace("@","",$page->instapage_id) }}">
                    {{ $page->instapage_id }}
                </a>
            </td>
            <td>{{ $page->user->name }}-{{$page->user->mobile}}</td>
            <td>{{ optional($page->categoryPage)->name }}</td>
            <td>{{ number_format($page->suggestprice) }}</td>
            <td>{{ number_format($page->price) }}</td>
            <td>


                @if($page->reason and $page->status == 0)
                    <span class=" label label-danger label-mini">غیرفعال</span>
                @endif


                @if(!$page->reason and $page->status == 0)
                    <span class=" label label-warning label-mini">معلق
                                        @if(is_null($page->pagedetail) and  $page->plan == "a")
                            -
                            در انتظار اتصال به مابینو
                        @endif
                                        </span>
                @endif

                @if($page->status == 1)
                    <span class="label label-success label-mini">فعال
                                        @if(is_null($page->pagedetail) and  $page->plan == "a")
                            -
                            در انتظار اتصال به مابینو
                        @endif
                                        </span>


                @endif


            </td>

            <td>
                @if($page->plan == "a")
                    <span class="badge" style="background-color: green">سیستمی</span>
                @else
                    <span class="badge" style="background-color: darkcyan">دستی</span>

                @endif
            </td>
            <td>


                @if($page->reason and $page->status == 0)
                    <span id="page_{{$page->id}}"
                          class="page_{{$page->id}} label label-success label-mini"
                          onclick="change_state_and_price('{{$page->id}}','{{$page->all_members-$page->fake_members}}')">تایید</span>

                @endif


                @if(!$page->reason and $page->status == 0)
                    <span id="page_{{$page->id}}"
                          class="page_{{$page->id}} btn-success  btn-xs  btn"
                          onclick="change_state_and_price('{{$page->id}}','{{$page->all_members-$page->fake_members}}')">تایید</span>


                    <span id="page_{{$page->id}}"
                          class="page_{{$page->id}}  btn-danger btn-xs btn"
                          onclick="change_state('{{$page->id}}')">رد</span>
                @endif

                @if($page->status == 1)
                    <span id="page_{{$page->id}}"
                          class="page_{{$page->id}} label label-danger label-mini"
                          onclick="change_state('{{$page->id}}')">رد</span>


                @endif


            </td>

            <td><span style="font-size:20px;color:green;cursor:pointer"
                      class="glyphicon glyphicon-eye-open modalAjax"
                      data-url="{{ route('admin.page.getDetailsAjax') }}"
                      data-id={{ $page->id }}></span></td>

            <td>
                <a href="{{ route("admin.pages.edit",$page) }}" class="btn btn-primary btn-xs"><i
                            class="icon-pencil"></i></a>

                @if($page->status ==  \App\Models\Page::ACTIVE &&!$page->getmabino_ad)
                    <a href="{{ route("admin.pages.sendAdFromMabino",$page->id) }}"
                       onclick="return confirm('آیا مطمئنی ؟ ');"
                       class="btn btn-default btn-xs btn-shadow">ارسال آگهی</a>
                @endif
            </td>
            <td>{{jdate($page->created_at)->format(" Y-m-d H:i")}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script src="/js/modalAjax.js"></script>
<script>

    change_state = function (id) {
        $("#pageAbortModal").modal("show");
        $("#sendReason").click(function (event) {
            var reason = $("#reason").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: '<?= url('admin/page/changestate') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                        reason: reason,
                        status: 1,
                    },

                    success: function (data) {

                        //    alert(data);
                        if (data == 'active') {


                            // document.getElementById('page_' + id).innerHTML = 'فعال';
                            // document.getElementById('page_' + id).classList.add('label-success');
                            //
                            // document.getElementById('page_' + id).classList.remove('label-danger');

                            // document.getElementById('comment_' + id).style.backgroundColor = '#33ff33';
                            // $("#state1_" + id).show();
                            // $("#state_" + id).hide();
                        }
                        else if (data == 'inactive') {
                            // document.getElementById('page_' + id).innerHTML = 'غیرفعال';
                            // document.getElementById('page_' + id).classList.add('label-danger');
                            //
                            // document.getElementById('page_' + id).classList.remove('label-success');


                        }
                        location.reload();
                    }
                });
        })

    }
    change_state_and_price = function (id, members) {

        var finalprice = 0;
        if (members < 5000) {
            finalprice = members * 1.4;
        } else if (members >= 5000 && members < 10000) {
            finalprice = members * 1.3;
        } else if (members >= 10000 && members < 50000) {
            finalprice = members * 1.2;
        } else if (members >= 50000 && members < 200000) {
            finalprice = members * 1.1;
        } else {
            finalprice = members * 1;
        }

        $("#price").val(Math.round(finalprice * 10));
        $("#pageprice").modal("show");

        $("#sendprice").click(function (event) {
            var price = $("#price").val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: '<?= url('admin/page/changestate') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                        price: price,
                        status: 0,
                    },

                    success: function (data) {

                        //    alert(data);
                        if (data == 'active') {


                            document.getElementById('page_' + id).innerHTML = 'فعال';
                            document.getElementById('page_' + id).classList.add('label-success');

                            document.getElementById('page_' + id).classList.remove('label-danger');

                            // document.getElementById('comment_' + id).style.backgroundColor = '#33ff33';
                            // $("#state1_" + id).show();
                            // $("#state_" + id).hide();
                        } else if (data == 'inactive') {
                            document.getElementById('page_' + id).innerHTML = 'غیرفعال';
                            document.getElementById('page_' + id).classList.add('label-danger');

                            document.getElementById('page_' + id).classList.remove('label-success');


                        }
                        $("#pageprice").modal("hide");
                        location.reload();
                    }

                });
        });
    };


</script>