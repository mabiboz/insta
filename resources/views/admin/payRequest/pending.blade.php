@extends('layouts.admin.admin')
@section('top_css')
    <style>
        span.label{cursor: pointer; }
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
                    url: '<?= url('/admin/PayRequest/pay') ?>',
                    type: 'POST',
                    data: 'id=' + id ,

                    success: function (data) {

                        //    alert(data);
                        if (data == 'active') {


                            document.getElementById('payrequest_' + id).innerHTML='پرداخت شده';
                            document.getElementById('payrequest_' + id).classList.add('label-success');

                            document.getElementById('payrequest_' + id).classList.remove('label-warning');


                        }
                        else if (data == 'inactive') {
                            document.getElementById('payrequest_' + id).innerHTML='درخواست معلق';
                            document.getElementById('payrequest_' + id).classList.add('label-warning');

                            document.getElementById('payrequest_' + id).classList.remove('label-success');



                        }
                    }
                });
        };

    </script>

@endsection
@section('content')

    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading">
                <button class="btn btn-default">لیست درخواست های واریز وجه</button>
            </header>

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i>شناسه</th>
                    <th><i class="icon-question-sign"></i>مبلغ</th>
                    <th><i class="icon-user"></i>نام درخواست دهنده</th>
                    <th><i class="icon-mobile-phone"></i>موبایل درخواست دهنده</th>
                    <th>شماره کارت</th>
                    <th>شماره حساب</th>
                    <th>شماره شبا</th>
                    <th><i class="icon-bookmark"></i>وضعیت</th>
                    <th><i class=" icon-edit"></i>تاریخ درخواست</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payrequests as $payrequest)

                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td>{{ persianFormat(number_format($payrequest->amount)) }}</td>
                        <td>{{ $payrequest->user->name}}</td>
                        <td>{{ $payrequest->user->mobile }}</td>
                        <td>{{ optional($payrequest->user->userDetails)->cart }}</td>
                        <td>{{ optional($payrequest->user->userDetails)->account_number }}</td>
                        <td>{{ optional($payrequest->user->userDetails)->sheba }}</td>

                        <td><span onclick="change_state('{{$payrequest->id}}')" id="payrequest_{{$payrequest->id}}" class="label
                         label-{{ ($payrequest->status == \App\Models\PayRequest::PENDING) ? 'warning' : 'success'}}
                                    label-mini">

                                    @if($payrequest->status==\App\Models\PayRequest::PENDING)
                                    {{ 'درخواست معلق' }}
                                @else
                                    {{ 'پرداخت شده' }}
                                @endif

                             </span></td>
                        <td>
                            @php
                                $jdf =new \App\Jdf();
                            @endphp
                            {{  getjalaliDate($payrequest->created_at) }}
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
            {{ $payrequests->render() }}
        </section>
    </div>



@endsection

