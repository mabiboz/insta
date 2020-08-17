@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2 panel panel-info">
            <h3 class="panel-heading ">افزودن آموزش جدید</h3>
            <div class="panel-body well">
                <form action="{{ route('admin.tutorial.store') }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}


                    <div class="form-group">
                        <label class=" control-label" for="title">عنوان آموزش</label>

                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                    </div>


                    <div class="form-group">

                        <div class="col-xs-12">
                            <textarea name="description" placeholder="توضیحات آموزش" class="form-control"
                                      id="description"
                                      cols="30" rows="10">{{ old('description','') }}</textarea>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class=" control-label" for="src">رسانه دیجیتال</label>

                        <input type="file" name="src" id="src">
                    </div>


                    <div class="form-group">
                        <label class=" control-label" for="level">آموزش مربوط به کدام دسته از کاربران می باشد ؟</label>

                        <select name="level" id="level" class="form-control">
                            @foreach($levels as $key => $level)
                                <option value="{{ $key }}">{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>


                    <input type="submit" class="btn btn-primary btn-block " value="ثبت آموزش">


                </form>

            </div>
        </div>
    </div>

    @include("admin.tutorials.sections.list")
@endsection
