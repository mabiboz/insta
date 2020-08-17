@include("user.dashboard.sections.modal")

@if(!is_null($lastNews))
    @include("user.dashboard.sections.popupNews")
@endif

<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-instagram"></i>
            </div>
            <div class="value">
                <h1>{{$pageCount}}</h1>
                <p>تعداد صفحات اینستاگرام شما</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-book-open"></i>
            </div>
            <div class="value">
                <h1>{{$campainCount}}</h1>
                <p>تعداد کمپین های شما</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-money"></i>
            </div>
            <div class="value">
                <h1>0</h1>
                <p>میزان درآمد شما</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-rocket"></i>
            </div>
            <div class="value">
                <h1>0</h1>
                <p>میزان هزینه کرد شما</p>
            </div>
        </section>
    </div>
</div>

@if(\Illuminate\Support\Facades\Auth::user()->role == \App\Models\User::ROLE_USER)
    @if((\Illuminate\Support\Facades\Auth::user()->agentRequest  and \Illuminate\Support\Facades\Auth::user()->agentRequest->status == \App\Models\AgentRequest::FAILED )
    or is_null(\Illuminate\Support\Facades\Auth::user()->agentRequest ))
<div class="row" style="zoom:120%">
    @foreach($agentLevels as $item)
        <div class="col-xs-12 col-md-4" style="direction: rtl; border-radius: 3px;">
            <div class="thumbnail" style="border-radius:8px;background-color:#ebeff0;">
                <div style="width:100%">

                        <img class="img-responsive" style="height:100%;width: 100%;" src="{{  config("UploadPath.agent_level_path").$item->image }}" alt="">


                </div>
                <div class="caption">

                        <span style="font-weight: bold;font-size:12px;" class="btn btn-block">{{ $item->title }}</span>







                    <p><span class="fa fa-bank"></span>قیمت : {{ persianFormat(number_format($item->price))  }} تومان</p>
                    <p>درصد تسهیم آگهی :
                    {{ $item->my_percent }}
                    </p>





                    <p>
              
                                  <button class="btn btn-sm btn-success modalAjax" data-id="{{ $item->id }}"
                                data-url="{{ route('user.dashboard.agentRequest.prefactor') }}"
                                style="margin-bottom: 2px; width: 100%;border-radius:5px;">
                            <span style="border-radius:5px;">خرید پنل نمایندگی</span>
                        </button>

                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endif
@endif



<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        <canvas id="myChart" width="100%" height="20"></canvas>-->

<!--    </div>-->
<!--</div>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['کمپین1', 'کمپین 2', 'کمپین3', 'کمپین4', 'کمپی5', 'کمپین6'],
            datasets: [{
                label: 'نمودار عملکرد کمپین های شما',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>