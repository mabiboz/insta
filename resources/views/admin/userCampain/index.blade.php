@extends("layouts.admin.admin")

@section("content")
    <div class="row">

        @include("admin.userCampain.sections.modal")


        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست کمپین های غیر مابینویی
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th>توضیحات</th>
                        <th>ایجاد شده توسط</th>
                        <th class="text-center">تاریخ ایجاد</th>
                        <th>تعداد صفحات</th>
                        <th>لیست صفحات</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campains as $campain)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $campain->title }}</td>
                            <td><span class="icon icon-list-ul modalAjax"
                                      data-url="{{ route('admin.userCampain.getDescription',$campain->id) }}"
                                      data-id="{{ $campain->id }}"></span></td>

                            <td>
                                {{ $campain->user->name  }} - {{ $campain->user->mobile }}
                            </td>
                            <td style="direction: ltr;text-align: center">
                                {{ jdate($campain->created_at)->format("Y/m/d H:i") }}
                            </td>

                            <td><span class="badge">{{ count($campain->pages) }}</span></td>
                            <td><span class="icon icon-list modalAjax"
                                      data-url="{{ route('admin.userCampain.getCampainPagesAjax') }}"
                                      data-id="{{ $campain->id }}"></span></td>

                            <td>
                                <a href="{{ route('admin.userCampain.PlanBAdlistAndCheckout',$campain->id) }}"
                                class="btn btn-info btn-xs"
                                >
                                    تسویه آگهی های دستی
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
