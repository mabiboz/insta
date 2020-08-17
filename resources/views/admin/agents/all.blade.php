@extends("layouts.admin.admin")


@section('top_css')
    <style>
        span.label {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

 <link rel="stylesheet" href="/calender/persian-datepicker.min.css">
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
                    url: '<?= url('admin/user/changestate') ?>',
                    type: 'POST',
                    data: 'id=' + id,

                    success: function (data) {

                        //    alert(data);
                        if (data == 'active') {


                            document.getElementById('user_' + id).innerHTML = 'فعال';
                            document.getElementById('user_' + id).classList.add('label-success');

                            document.getElementById('user_' + id).classList.remove('label-danger');


                        }
                        else if (data == 'inactive') {
                            document.getElementById('user_' + id).innerHTML = 'غیرفعال';
                            document.getElementById('user_' + id).classList.add('label-danger');

                            document.getElementById('user_' + id).classList.remove('label-success');


                        }
                    }
                });
        };

    </script>

@endsection

@section("bottom_js")
    <script src="/calender/persian-date.min.js"></script>
    <script src="/calender/persian-datepicker.min.js"></script>

@endsection

@section("content")


    <div class="row">
        <div class="col-lg-12">
            @include("admin.agents.sections.modal")

            <section class="panel">
                <header class="panel-heading">
                  لیست نمایندگان
                </header>
                <table class="table  table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>موبایل</th>
                        <th>تلفن ثابت</th>
                        <th>ایمیل</th>
                        <th>تاریخ ایجاد</th>
                        <th>جنسیت</th>
                        <th>وضعیت</th>
                        <th>اعتبار
                        <span style="font-size: 10px">(تومان)</span>
                        </th>
                        <th>ویرایش</th>
                        <th>صفحات </th>
                          <th>ادمین ها </th>
                        <th>کمپین ها</th>
                        <th>درخواست ها</th>
                        <th>گزارش ها</th>
                        <th>تیکت ها</th>
                         <th>زیر/سر گروه</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr  class=" {{ $user->is_admin ?  'alert alert-success ' : '' }}">
                          <td>{{$loop->iteration +(( $users->currentPage() - 1) *   $users->perPage())}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>

                            <td>{{jdate($user->created_at)->format(" Y-m-d H:i")}}  </td>
                            <td>
                                @if($user->sex == 1)
                                    <span class="label label-success label-mini">مرد</span>

                                @else
                                    <span class="label label-danger label-mini">">زن</span>

                                @endif

                            </td>
                            <td>
                                @if($user->status == \App\Models\User::ACTIVE)
                                    <span id="user_{{$user->id}}" class="user_{{$user->id}} label label-success label-mini"
                                          onclick="change_state('{{$user->id}}')">فعال</span>

                                @else
                                    <span id="user_{{$user->id}}" class="user_{{$user->id}} label label-danger label-mini"
                                          onclick="change_state('{{$user->id}}')">غیرفعال</span>

                                @endif
                            </td>

                            <td><span class="fa fa-plus modalAjax" data-url="{{route('admin.wallet.charge',$user->id)}}" data-id="{{$user->id}}"></span>{{ number_format($user->wallet->sum) }}</td>
                            <td><span class="glyphicon glyphicon-edit modalAjax"
                              data-url="{{ route('admin.user.edit') }}" data-id="{{ $user->id }}"
                            ></span></td>
                          <td><span class="glyphicon glyphicon-eye-open modalAjax"
                                data-id="{{ $user->id }}" data-url="{{ route('admin.user.pages') }}"
                                ></span></td>
                                
                              <td><span class="glyphicon glyphicon-eye-open modalAjax"
                                      data-id="{{ $user->id }}" data-url="{{ route('admin.user.adminsOfAgent') }}"
                                ></span></td>
                            <td><span class="fa fa-users modalAjax" data-url="{{route('admin.user.campain.list',$user->id)}}" data-id="{{$user->id}}"></span></td>
                            <td><span class="fa fa-file modalAjax" data-url="{{route('admin.user.payrequest.list',$user->id)}}" data-id="{{$user->id}}"></span></td>
                            <td><span class="fa fa-clipboard"></span></td>
                            <td><span class="fa fa-tags modalAjax" data-url="{{ route('admin.user.ticketList') }}" data-id="{{ $user->id }}"></span></td>

     <td><span class="fa fa-grin-beam modalAjax" data-url="{{ route('admin.user.parentAndChild') }}"
                                      data-id="{{ $user->id }}"></span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->render() }}
            </section>
        </div>
    </div>
@endsection
