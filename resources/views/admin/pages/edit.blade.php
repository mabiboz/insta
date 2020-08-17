@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h3 class="alert alert-info">ویرایش صفحه
            {{ $page->name }}
            </h3>

            <form action="{{ route("admin.pages.update",$page) }}" method="post">
                @include("admin.pages.sections.formFields")
                <button type="submit" class="btn btn-warning">ویرایش</button>
            </form>
        </div>
    </div>
@endsection
