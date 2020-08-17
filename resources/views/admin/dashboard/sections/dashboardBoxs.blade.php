<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <div class="value">
                <h1>{{$userCount}}</h1>
                <p>کل کاربران </p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="icon-user"></i>
            </div>
            <div class="value">
                <h1>{{$pageOwnerCount}}</h1>
                <p>تعداد ادمین ها</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="icon-tags"></i>
            </div>
            <div class="value">
                <h1>{{$pageCount}}</h1>
                <p>تعداد صفحات درج شده</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="icon-adn"></i>
            </div>
            <div class="value">
                <h1>{{$adCount}}</h1>
                <p>تعداد کل آگهی های دریافتی</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="icon-money"></i>
            </div>
            <div class="value">
                <h1>{{number_format($incom)}}</h1>
                <p>سود خالص</p>
            </div>
        </section>
    </div>

    <style>
        .panel{
            background-color: #595B5D;
        }
    </style>