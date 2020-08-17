@extends("layouts.user.user")

@section("bottom_js")
    <script>
        var ratio = {{getRatio($campain_data['dayCount'] )}}
    
        var fullPrice = {{ $pages->sum("price") }}
      
        $(".selectPage").change(function () {
            if ($(this).is(":checked")) {
                
                fullPrice += parseInt($(this).data('price')) ;
            } else {
                fullPrice -= parseInt($(this).data('price'));
            }
            $("p#fullPrice").html("قیمت کل : " + fullPrice +" * "
           + ratio
            +
            "= "
            +
            fullPrice*ratio + " تومان");
        });
    </script>


    <script>
        $("#btnAddToFavList").click(function (event) {
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"{{ route('user.campain.addToFav') }}",
                data:{},
                success:function (response) {
                    if(response['result'] == 1){
                        toastr.success("با موفقیت به لیست علاقه مندی ها اضافه شد !");
                    }else if(response['result'] == -1){
                        toastr.warning("این آگهی ، در لیست علاقه مندی های شما موجود است !");

                    }else{
                        toastr.error("متاسفانه مشکلی رخ داده ! چند لحظه بعد تلاش کنید !");
                    }
                },
            });

        });
    </script>

@endsection

@section("content")


    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <section class="panel-heading">
                    اطلاعات کمپین و آگهی
                    <button class="btn btn-shadow btn-primary" id="btnAddToFavList">
                        افزودن کمپین و آگهی به لیست علاقه مندی ها
                        <span class="icon icon-plus"></span>
                    </button>
                </section>
                <section class="panel">

                    <div class="panel-body bio-graph-info">
                        <div class="row">
                            <div class="col-xs-12">
                                <p><span class="badge">نام کمپین  </span>: {{ $campain_data['campain_name'] }}</p>
                            </div>


                            <div class="col-xs-12">
                                <p style="text-align: justify;line-height: 30px;"><span class="badge"> محتوا آگهی </span>: {{ $campain_data['ad_content'] }}</p>
                            </div>
                            <div class="col-xs-12">
                                <p style="text-align: justify;line-height: 30px;"><span class="badge">تعداد روز انتشار </span>: {{ $campain_data['dayCount'] }}</p>
                            </div>
                            <div class="col-xs-12">
                                <p style="text-align: justify;line-height: 30px;"><span class="badge">مهلت پذیرش توسط پیج دارها</span>: {{ $campain_data['expired_at'] }}</p>
                            </div>
                         @if($typeMedia == "image")
                            <img  style="width: 300px;" class="img-responsive"
                                    src="{{ config("UploadPath.ad_image_path").session("ad_image_name") }}" alt="">
                            @else
                                <video src="{{ config("UploadPath.ad_image_path").session("ad_image_name") }}"
                                width="300" controls height="200" preload="none"
                                ></video>
                            @endif


                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">
            <form action="{{ route('user.campain.store') }}" method="post">
                {{ csrf_field() }}
                <h3 class="alert alert-info">فاکتور خرید</h3>

                <p>لیست صفحات انتخاب شده :</p>
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th>انتخاب</th>
                        <th>نام صفحه</th>
                        <th>آدرس صفحه</th>
                        <th>قیمت</th>
                        <th>دسته بندی صفحه</th>
                        <th>جنسیت مخاطبین</th>
                        <th>رده سنی مخاطبین</th>
                        <th>تعداد فالوورها</th>
                        <th>حوزه جغرافیایی فعالیت صفحه</th>
                    </tr>
                    @foreach($pages as $page)
                        <tr>
                            <td><input type="checkbox" value="{{ $page->id }}" class="selectPage"
                                       data-price="{{$page->price}}"
                                       name="selectPage[]" checked></td>
                            <td>{{ $page->name }}</td>
                            <td style="direction: ltr" class="text-right">{{ $page->instapage_id }}</td>
                            <td>{{ persianFormat(number_format( $page->price))  }} تومان</td>
                            <td>{{ $page->categoryPage->name }}</td>
                            <td>{{ $sexPages[$page->sex] }}</td>
                            <td>{{ $age_contact[$page->age_contact] }}</td>
                            <td>{{ $page->all_members }}</td>
                            <td>{{ $page->city->name }}</td>
                        </tr>
                    @endforeach

                    </thead>
                </table>

                <div class="alert alert-success">
                    <p id="fullPrice">قیمت کل :
                        {{ $pages->sum('price') }}
                        
                        *
                        
                        {{ $campain_data['dayCount'] }} 
                        
                        =
                            
                        {{ $pages->sum('price') * getRatio($campain_data['dayCount'] ) }}
                        تومان
                    </p>
                </div>

                <button class="btn btn-primary">ثبت نهایی</button>
            </form>
        </div>
    </div>

@endsection
