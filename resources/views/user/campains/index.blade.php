@extends("layouts.user.user")

@section("content")
    <div class="row">
        @include("user.campains.sections.modal")

        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست کمپین ها

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th>توضیحات</th>
                        <th>تعداد صفحات</th>
                        <th>لیست صفحات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campains as $campain)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $campain->title }}</td>
                            <td><span class="icon icon-list-ul modalAjax"  data-url="{{ route('user.campain.getDescription',$campain->id) }}" data-id="{{ $campain->id }}"></span></td>
                            <td><span class="badge">{{ count($campain->pages) }}</span></td>
                            <td><span class="icon icon-list modalAjax"  data-url="{{ route('user.campain.getCampainPagesAjax') }}" data-id="{{ $campain->id }}"></span></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
