@extends("layouts.admin.admin")
@section("bottom_scripts")
    <script>
        $("#pageUrl").keyup(function () {
            var url = $("#pageUrl").val();
            $.ajax({
                url: '/admin/getUrls',
                type: 'get',
                dataType: 'json',
                data: {
                    url:url
                }
                ,
                success: function (response) {
                    $("#resultOfVisited").html("");
                    response.forEach(function (item) {
                        $("#resultOfVisited").append("<div> <span class='btn btn-primary'>"+item.url+"</span>  <span class='badge'>"+item.count+"</span></div>");
                    });


                }
                ,
                error: function () {

                }


            });
        });
    </script>
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">


            <div class="col-xs-12 alert alert-info">

                <h3 class="text-center">
                    تعداد افراد بازدید کننده از سایت در امروز:
                    {{$visitCount}}
                </h3>

                <h3 class="text-center">
                    تعداد افراد بازدید کننده از سایت در دیروز:
                    {{   $visitCountYesterday}}
                </h3>

            </div>


        </div>


    </div>


    <div class="row">
    <div class="col-xs-12">

        <div  style="position: relative; height:40vh; width:80vw">
            <canvas id="myChart" width="200" height="50"></canvas>
        </div>

    </div>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {

                labels: [
                    @for($i=7;$i>=1;$i--)
                            "{{$i}} روز قبل",
                    @endfor
                ],
                datasets: [{
                    label: 'تعداد بازدید',
                    fill: false,
                    data: [
                        @foreach ($visitChart as $sum)
                                "{{ $sum }}",
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($visitChart as $sum)
                                'rgba(100, 30, 132, 0.2)',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach($visitChart as $sum)
                                'rgba(50, 60, 2, 0.2)',
                        @endforeach
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>



    </div>










@endsection
