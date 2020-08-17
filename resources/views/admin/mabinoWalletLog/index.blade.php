@extends('layouts.admin.admin')

@section('content')

    @include("user.walletlogs.sections.modal")
    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading">
                <button class="btn btn-default">گردش حساب کیف پول شما</button>
            </header>

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i>شناسه</th>
                    <th><i class="icon-question-sign"></i>مبلغ</th>
                    <th><i class="icon-bookmark"></i>روش ایجاد از طریق</th>
                    <th><i class=" icon-edit"></i>افزایش / کاهش</th>
                    <th><i class=" icon-edit"></i>تاریخ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($walletLogs as $walletLog)

                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td>{{ persianFormat(number_format($walletLog->price)) }}</td>
                        <td>
                            @foreach($methodsCreateWallet as $key=>$value)
                                @if($key == $walletLog->method_create)
                                    {{ $value }}
                                @endif

                            @endforeach

                        </td>
                        <td><span class="label
                         label-{{ ($walletLog->wallet_operation == \App\Models\WalletLog::INCREMENT) ? 'info' : 'danger'}}
                                    label-mini">
                                 @foreach($walletOperations as $key=>$value)
                                    @if($key == $walletLog->wallet_operation)
                                        {{ $value }}
                                    @endif

                                @endforeach
                             </span></td>
                        <td>
                            @php
                                $jdf =new \App\Jdf();
                            @endphp
                            {{  getjalaliDate($walletLog->created_at) }}
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </section>
    </div>



@endsection

