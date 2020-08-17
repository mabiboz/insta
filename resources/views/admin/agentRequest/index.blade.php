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
                    url: "{{ route('admin.agentRequests.changeState') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        newStatus: 2,

                    },
                    success:function (response) {
                        location.reload();
                    }

                });
        };

        change_state_off = function (id) {
            $("#abortReason").modal("show");

            $("#sendReason").click(function (event) {


                var reason_content = $("#reason_content").val();
                $.ajax(
                    {
                        url: "{{ route('admin.agentRequests.changeState') }}",
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

    @include("admin.agentRequest.sections.modal")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست درخواست های نمایندگی

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>نام کاربر</th>
                        <th>موبایل</th>
                        <th>نوع پنل درخواستی</th>
                        <th><i class=" icon-edit"></i>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agentRequests as $agentRequest)
                        <tr>
                           <td>{{$loop->iteration +(( $agentRequests->currentPage() - 1) *   $agentRequests->perPage())}}</td>
                            <td>{{ $agentRequest->user->name }}</td>
                            <td>{{ $agentRequest->user->mobile }}</td>
                             <td>{{ $agentRequest->agentLevel->title }}</td>

                            <td>
                               
                                @if($agentRequest->status == \App\Models\AgentRequest::PENDING)
                                    <button
                                            onclick="change_state({{ $agentRequest->id }})"
                                            class="btn btn-shadow btn-success btn-xs">تایید
                                    </button>

                                    <button onclick="change_state_off({{ $agentRequest->id }})"
                                            class="btn btn-shadow btn-danger btn-xs">رد
                                    </button>


                                @elseif($agentRequest->status == \App\Models\AgentRequest::ACCEPTED)
                                    <span class="btn btn-success btn-xs">
                                        {{ $agentRequestStatus[$agentRequest->status] }}
                                    </span>
                                @else
                                    <span class="btn btn-danger btn-xs">
                                        {{ $agentRequestStatus[$agentRequest->status] }}
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $agentRequests->links() }}
                </div>
            </section>
        </div>
    </div>
@endsection
