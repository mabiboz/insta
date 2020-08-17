@extends("layouts.user.user")

@section("content")
    <div class="row">
        @include("agent.admin.sections.modal")


        <section class="panel">
            <header class="panel-heading">
                لیست زیرمجموعه های شما
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
                    <th>تعداد صفحات</th>
                    <th>گزارش عملکرد</th>

                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr  class=" {{ $user->is_admin ?  'alert alert-success ' : '' }}">
                        <td>{{ $loop->iteration }}</td>
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



                        <td><span class="badge">{{$user->pages->count()}}</span></td>
                        <td><span class="icon icon-eye-open modalAjax"
                                  data-id="{{ $user->id }}" data-url="{{ route('agent.admin.reportAct') }}"></span></td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
@endsection
