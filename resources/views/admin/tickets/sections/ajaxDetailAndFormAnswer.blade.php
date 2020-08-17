<section class="panel">
    <header class="panel-heading">
        جزئیات تیکت
        <span class="badge">
            TicketID-{{ $boxMessaging->id }}
        </span>


    </header>
    <div class="panel-body profile-activity">

        @foreach($boxMessaging->ticketMessagings as $ticket)
            <div class="activity terques">
                                    <span>
                                        <i class="icon-user"></i>
                                    </span>


                <div class="activity-desk">
                    <div class="panel" style="width: 100%">
                        <div class="panel-body">
                            <div class="arrow"></div>
                                  <i class=" icon-time"></i>
                            <h4>{{jdate($ticket->created_at)->format(" Y-m-d H:i")}}  </h4>
                      
                            <h4>{{ $ticket->title }}</h4>
                            <p style="line-height: 30px;text-align: justify">
                                {{ $ticket->content }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($ticket->ticketAnswers as $answer)
                <div class="activity alt purple">
                <span>
                    <i class="icon-user-md"></i>
                </span>
                    <div class="activity-desk">
                        <div class="panel" style="width: 100%;">
                            <div class="panel-body">
                                <div class="arrow-alt"></div>
                                <i class=" icon-time"></i>
                                <h4>{{jdate($answer->created_at)->format(" Y-m-d H:i")}}  </h4>
                                <p>
                                    {{ $answer->content  }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        @if($boxMessaging->status == \App\Models\BoxMessaging::OPEN)
            <div class="col-xs-12 badge " style="margin-bottom: 20px">
                <p>متن پاسخ</p>
                <form action="{{ route('admin.ticket.registerAnswer',$boxMessaging->ticketMessagings()->latest()->first()->id) }}"
                      method="post">
                    {{ csrf_field() }}
                    <textarea name="answerContent" id="answerContent" class="form-control"></textarea>
                    <br>
                    <button class="btn btn-primary btn-shadow">ثبت پاسخ</button>
                </form>
            </div>
        @endif


    </div>
</section>