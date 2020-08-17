@if(count($tickets))
    <div class="row">
        @foreach($tickets as $ticket)
            <div class="col-xs-12 well" style="margin-top: 10px">
                <p>عنوان :
                    <span class="badge">
                    {{ $ticket->boxMessaging->title }}
                       ( {{jdate($ticket->created_at)->format(" Y-m-d H:i")}} )
                </span>
                    <span>
                @if($ticket->status == \App\Models\TicketMessaging::ANSWERED)
                            <button class=" btn btn-success btn-xs">پاسخ داده شده</button>

                        @else
                            <button class=" btn btn-warning btn-xs">در انتظار پاسخ</button>
                        @endif
                    </span>
                </p>

                <p>
                    سوال :
                    {{ $ticket->content }}
                </p>


            </div>
            @foreach($ticket->ticketAnswers as $answer)
                <div style="margin-top: 0;margin-bottom: 0;margin-right: 10px;background-color: #2ab27b;border-radius: 3px;border: 1px solid gray;padding: 5px">
                    <h4> (
                        {{jdate($answer->created_at)->format(" Y-m-d H:i")}}
                    )</h4>
                    <p>
                        {{ $answer->content  }}
                    </p>
                </div>



            @endforeach

        @endforeach
    </div>

@else
    <p class="alert alert-dangrt">
        هیچ تیکتی یافت نشد !
    </p>
@endif