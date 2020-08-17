<div class="row text-center">
    <div class="col-xs-12">
        <img src="{{ config("UploadPath.agent_level_path"). $agentLevel->image }}" width="60%"alt="">
    </div>
    <div class="col-xs-12">
        <p class="text-center">
            {{ $agentLevel->title }}
        </p>
    </div>
       <div class="col-xs-12">
        <p class="text-center">
            قیمت : 
         {{ persianFormat(number_format($agentLevel->price)) }}  تومان
        </p>
    </div>
    <div class="col-xs-12">
        <p>
            درصد شما از تسهیم سود آگهی :
        </p>
        {{ $agentLevel->my_percent }}
    </div>

    @if(\Illuminate\Support\Facades\Auth::user()->wallet->sum >= $agentLevel->price)
        <form action="{{ route('user.requestConvertToAgent') }}" method="get">
            {{ csrf_field() }}
            <input type="radio" checked style="display: none" name="agentLevel" value="{{ $agentLevel->id }}">

            <button class="btn btn-primary btn-shadow btn-block">پرداخت</button>

        </form>
    @else
        <p class="alert alert-danger">
            اعتبار شما کافی نمی باشد ! مبلغ
            {{ $agentLevel->price -  \Illuminate\Support\Facades\Auth::user()->wallet->sum }}
            تومان را آنلاین پرداخت نمایید !
        </p>
                <a href="{{ route('user.dashboard.agentRequest.payment',$agentLevel) }}" class="btn btn-success btn-block btn-shadow">انتقال به درگاه بانک</a>


    @endif
</div>


