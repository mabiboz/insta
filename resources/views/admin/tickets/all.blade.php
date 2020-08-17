@extends("layouts.admin.admin")



@section("content")


    <div class="row">
        <div class="col-lg-12">
            @include("admin.tickets.sections.modal")

            <section class="panel">
                <header class="panel-heading">
                    لیست تیکت ها
               
               <div class="text-left" style="font-size: 12px">
                        <span class="fa fa-2x fa-question-circle"></span>
                        <span style="display: inline-block;padding: 6px;background-color: #b22626"></span>
                        <span>                        تیکت های بدون پاسخی که در 3 روز گذشته ثبت شده اند !
                    </span>

                        <span style="display: inline-block;padding: 6px;background-color: #fec730"></span>
                        <span>تیکت های بدون پاسخی که قبل از 3 روز پیش ثبت شده اند !</span>
                    </div>
                </header>
                <table class="table  table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>موبایل</th>
                        <th>عنوان تیکت</th>
                        <th>وضعیت</th>
                        <th>مشاهده و پاسخ</th>
                        <th>تاریخ ثبت</th>
                        <th>عملیات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($boxMessages as $boxMessage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional(optional($boxMessage->ticketMessagings()->latest()->first())->user)->name }}</td>
                            <td>{{ optional(optional($boxMessage->ticketMessagings()->latest()->first())->user)->mobile }}</td>
                            <td>{{ $boxMessage->title }}</td>
                            <td>
                                @if($boxMessage->status == \App\Models\BoxMessaging::OPEN)
                                    <span class="btn btn-default btn-shadow btn-xs">
                                            تیکت باز
                                    </span>
                                @else
                                    <span class="btn btn-danger btn-shadow btn-xs">
                                       تیکت بسته شده
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="glyphicon glyphicon-eye-open modalAjax"
                                      data-id="{{ $boxMessage->id }}"
                                      data-url="{{ route('admin.ticket.detailAndShowFormAnswer') }}"></span>
                                     
                                        @if(!is_null($boxMessage->ticketMessagings()->latest()->first()))
                                    @if(count($boxMessage->ticketMessagings()->latest()->first()->ticketAnswers) == 0)
                                        @if(\Carbon\Carbon::now()->subDays(3)->lessThanOrEqualTo($boxMessage->ticketMessagings()->latest()->first()->created_at))
                                            <img src="/mabino/img/flashDot.gif" width="30" height="30">
                                        @else
                                            <img src="/mabino/img/flashDot2.gif" width="30" height="30">

                                        @endif
                                    @endif
                                @endif
                          
                            </td>
                            <td>{{jdate(optional($boxMessage->ticketMessagings()->latest()->first())->created_at)->format(" Y-m-d H:i")}}  </td>

                            <td>
                                @if($boxMessage->status == \App\Models\BoxMessaging::OPEN)
                                    <a href="{{ route("admin.ticket.close",$boxMessage) }}"
                                       class="btn btn-shadow btn-primary btn-xs">بستن تیکت</a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    {{ $boxMessages->links() }}
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
