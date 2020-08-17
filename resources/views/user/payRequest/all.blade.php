@extends('layouts.user.user')

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
                    <th><i class="icon-bookmark"></i>وضعیت</th>
                    <th><i class=" icon-edit"></i>تاریخ درخواست</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payrequests as $payrequest)

                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td>{{ persianFormat(number_format($payrequest->amount)) }}</td>
                        <td><span class="label
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
        </section>
    </div>



@endsection

