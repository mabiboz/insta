@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2 panel panel-info">
            <h3 class="panel-heading ">افزودن تبلیغ جدید</h3>
            <div class="panel-body well">
                <form action="{{ route('admin.newAdFromMabino.store') }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}


                    <div class="form-group">

                        <div class="col-xs-12">
                            <textarea name="ad_content" placeholder="محتوا آگهی" class="form-control" id="ad_content"
                                      cols="30" rows="10">{{ old('ad_content','') }}</textarea>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class=" control-label" for="ad_image">تصویر آگهی</label>

                        <input type="file" name="ad_image" id="ad_image">
                    </div>


                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="control-label" for="is_mabinoe">
                                <input type="checkbox" name="is_mabinoe" id="is_mabinoe">
                                آگهی مابینویی است !
                            </label>
                        </div>


                    </div>

                    <input type="submit" class="btn btn-primary btn-block " value="ثبت آگهی">


                </form>

            </div>
        </div>
    </div>

    @include("admin.newAd.sections.list")
@endsection
