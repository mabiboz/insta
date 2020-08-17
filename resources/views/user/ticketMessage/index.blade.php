@extends("layouts.user.user")

@section("content")
    @include("user.ticketMessage.sections.modal")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست تیکت های شما

                </header>


                <table class="table table-inbox table-hover">
                    <tbody>
                    <tr>
                        <th>TicketID</th>
                        <th>عنوان</th>
                        <th>نمایش تیکت</th>
                        <th>وضعیت</th>
                    </tr>
                    @foreach($boxMessages as $box)
                        <tr class=" {{ $box->status == \App\Models\BoxMessaging::OPEN ? 'read' : 'unread'}} ">
                            <td class="view-message"><span class="badge">TicketID-{{ $box->id }}</span></td>
                            <td class="view-message">{{ $box->title }}</td>
                            <td class="view-message modalAjax" data-url="{{ route('user.ticket.showContent') }}"
                                data-id="{{ $box->id }}">
                                <span class="icon icon-eye-open"></span>
                            </td>
                            <td class="view-message ">
                                @if($box->status == \App\Models\BoxMessaging::OPEN)
                                    <button class=" btn btn-success btn-xs">تیکت باز</button>

                                @else
                                    <button class=" btn btn-warning btn-xs">تیکت بسته شده</button>
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
