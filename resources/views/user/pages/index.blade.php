@extends("layouts.user.user")


@section("bottom_js")
    <script>
        $(".modalAjaxConnectToInstagram").click(function (event) {
            event.preventDefault();
            var url = $(this).data('url');
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                },
                success: function (response) {
                    $("#ajaxModalConnectToInstagram .modal-body").html(response);
                    $("#ajaxModalConnectToInstagram").modal("show");

                }
            });

        });
    </script>
    
    
    <script>
        change_state = function (id) {
          
       

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax(
                    {
                        url: '<?= url('user/pages/publication/changestate') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                           
                          
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
                            } else if (data == 'inactive') {
                                // document.getElementById('page_' + id).innerHTML = 'غیرفعال';
                                // document.getElementById('page_' + id).classList.add('label-danger');
                                //
                                // document.getElementById('page_' + id).classList.remove('label-success');


                            }
                            location.reload();
                        }
                    });
       

        }

     
    </script>
    
@endsection


@section("content")


    @include("user.campains.sections.modal")
    @include('user.pages.sections.modalConnectToInstagram')

    <div class="row">


        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست صفحات

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th><i class=" icon-tags"></i>آدرس صفحه</th>
                        <th><i class="icon-bookmark"></i>دسته بندی</th>
                        <th>حوزه جغرافیایی فعالیت</th>
                        <th>محدوده سنی مخاطبین</th>
                        <th>جنسیت مخاطبین</th>
                        <th>تعداد کل فالوورها</th>

                        <th>تعداد فالوورهای فیک</th>
                        <th>قیمت تعیین شده</th>
                        <th>نحوه انتشار آگهی</th>
                        <th><i class=" icon-edit"></i>وضعیت</th>
                        <th>اتصال صفحه به اینستاگرام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->name }}</td>
                            <td>{{ $page->instapage_id }}</td>
                            <td>{{ optional($page->categoryPage)->name }}</td>
                            <td>{{ $page->city->name }}</td>

                            <td>{{ $ageContacts[$page->age_contact] }}</td>
                            <td>{{ $sexContact[$page->sex] }}</td>
                            <td>{{ $page->all_members }}</td>
                            <td>{{ $page->fake_members }}</td>
                            <td>
                                @if($page->status == \App\Models\Page::ACTIVE)
                                  
                                    
                                    
                                     @if ($page->reagent) 
            
           {{ number_format( $page->reagentLevel->pageowner_percent / 100*$page->price)}}
           
          
        @else
        
        {{number_format($page->price*config("SharingConfig.PERCENT_OF_PAGE_OWNER"))}}
        @endif
                                    
                                    
                                    
                                    تومان
                                @else
                                    <span class="btn btn-warning">نامشخص</span>
                                @endif
                            </td>

                            <td>
                                @if($page->plan == "a")
                                    <span>سیستمی</span>
                                   
                                      <a id="page_{{$page->id}}"
    class="page_{{$page->id}} btn btn-success btn-xs" href='/user/pages/publication/changestate/{{$page->id}}'>تغییر حالت انتشار</a>

                                @elseif($page->plan == "b")
                                    <span>دستی </span>
                                    <br>
                                        <a id="page_{{$page->id}}"
    class="page_{{$page->id}} btn btn-success btn-xs" href='/user/pages/publication/changestate/{{$page->id}}'>تغییر حالت انتشار</a>
                                @else
                                    -
                                @endif
                            </td>


                            <td>
                                @if($page->plan == "a")
                                    @if($page->status == \App\Models\Page::ACTIVE)
                                        <span class="label label-success label-mini">فعال</span>

                                    @else
                                        @if(is_null($page->pagedetail))
                                            <span class="label label-info label-mini" style="font-size:10px">در انتظار اتصال به اینستاگرام</span>
                                        @else
                                            @if($page->reason)
                                                <button class="btn btn-danger label-mini modalAjax"
                                                        data-id="{{$page->id}}"
                                                        data-url="{{route('user.pages.getReasonAbort')}}">غیرفعال
                                                </button>
                                            @else
                                                <span class="label label-warning label-mini">در انتظار بررسی</span>

                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if($page->status == \App\Models\Page::ACTIVE)
                                        <span class="label label-success label-mini">فعال</span>

                                    @else
                                        @if($page->reason)
                                            <button class="btn btn-danger label-mini modalAjax"
                                                    data-id="{{$page->id}}"
                                                    data-url="{{route('user.pages.getReasonAbort')}}">غیرفعال
                                            </button>
                                        @else
                                            <span class="label label-warning label-mini">در انتظار بررسی</span>

                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($page->plan == "a")
                                    <a class="icon icon-list modalAjaxConnectToInstagram"
                                       data-url="{{ route('user.pagedetails.setDetailAjax') }}"
                                       data-id="{{ $page->id }}"></a>
                                    @if($page->pagedetail)
                                        <span class="badge badge-success"
                                              style="background-color:green">متصل به مابینو</span>
                                    @else
                                        <span class="badge badge-danger" style="background-color:red"> نامتصل </span>
                                    @endif
                                @else
                                    -
                            @endif
                            <td>


                                <a href="{{ route("user.pages.edit",$page) }}" class="btn btn-primary btn-xs"><i
                                            class="icon-pencil"></i></a>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>


@endsection
