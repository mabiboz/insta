@extends('layouts.admin.admin')

@section('content')

    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading">
                <button class="btn btn-default">لیست پرداخت های موفق</button>
            </header>

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>مبلغ(ریال)</th>
                    <th>کد پیگیری</th>
                    <th>شماره کارت</th>
                    <th>تاریخ پرداخت</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)

                    <tr>
                        <td>{{$loop->iteration +(( $transactions->currentPage() - 1) *   $transactions->perPage())}}</td>
                        <td>{{ persianFormat(number_format($transaction->price)) }}</td>
                        <td>{{ $transaction->tracking_code}}</td>
                        <td>{{ $transaction->card_number}}</td>
                        <td>{{ getjalaliDate(\Carbon\Carbon::parse($transaction->payment_date)) }}</td>


                    </tr>
                @endforeach


                </tbody>
            </table>
            {{ $transactions->render() }}

        </section>
    </div>




@endsection

