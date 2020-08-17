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

                @if(!is_null($walletLog->detail))
                    (
                    از صفحه
                    {{ optional($walletLog->detail->page)->instapage_id }}
                    در کمپین

                    {{ optional($walletLog->detail->campain)->title }}
                    )

                @endif
                @if($walletLog->method_create == \App\Models\WalletLog::TASHVIGHI)
                    <span>(
                        {{ $walletLog->description }}
                        )
                    </span>
                @endif
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