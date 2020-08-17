@extends("layouts.admin.admin")

@section("content")
    <div class="row">

        <div class="col-xs-12 col-md-4 col-md-offset-4">
            @include("admin.categoryPages.sections.form")
        </div>

        <div class="col-xs-12 col-md-6 col-md-offset-3 well">
            <section class="panel">
                <header class="panel-heading">
                    لیست دسته بندی صفحات

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>

                            <td>
                                <a href="{{ route('admin.categoryPage.edit',$category) }}" class="btn btn-primary btn-xs"><i
                                            class="icon-pencil"></i></a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
