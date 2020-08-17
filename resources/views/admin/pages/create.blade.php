@extends("layouts.admin.admin")

@section("content")
      <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
              <h3 class="alert alert-info">درج صفحه جدید</h3>

              <form action="{{ route("user.pages.store") }}" method="post">
                  @include("user.pages.sections.formFields")
                  <button type="submit" class="btn btn-primary">ثبت</button>
              </form>
          </div>
      </div>
@endsection
