@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        @include("admin.mabinoCampain.sections.modal")

        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست کمپین های ثبت شده توسط مابینو

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th>توضیحات</th>
                        <th>تعداد صفحات</th>
                        <th>لیست صفحات</th>
                        <th>تاریخ ایجاد کمپین</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resultCampain as $ad_id=>$campainsCollection)
                        @foreach($campainsCollection as $date=>$campains)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $campains->first()->title }}</td>
                                <td>
                                <span class="icon icon-list-ul modalAjax"
                                      data-url="{{ route('admin.mabinoCampain.getDescription',$campains->first()->id) }}"
                                      data-id="{{ $campains->first()->id }}"></span></td>


                                <td><span class="badge">{{ count($campains) }}</span></td>
                                <td><span class="icon icon-list modalAjax"
                                          data-url="{{ route('admin.mabinoCampain.getCampainPagesAjax') }}"
                                          data-id="{{ $ad_id }}*{{ $date }}"></span></td>


                                <td>
                                    {{ jdate($date)->format("d - m  - Y") }}
                                </td>

                            <td>
                                <a href="{{ route('admin.mabinoCampain.PlanBAdlistAndCheckout',['ad'=>$ad_id,'date'=>$date]) }}" class="btn btn-primary btn-xs">
                                    تسویه آگهی های دستی
                                </a>
                            </td>
                            </tr>

                        @endforeach
                    @endforeach

                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
