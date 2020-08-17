<fieldset title="گام سوم" class="step  col-xs-12 col-md-8 col-md-offset-2" id="default-step-2" style="display: block;">
    <legend>ثبت آگهی</legend>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="ad_content">توضیحات آگهی</label>
        <div class="col-xs-12 col-md-8">
            <textarea name="ad_content" placeholder="محتوا آگهی" class="form-control" id="ad_content" cols="30" rows="10">{{ old('ad_content','') }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="dayCount">تعداد روز انتشار پست</label>
        <div class="col-xs-12 col-md-8">
            <input type="number" class="form-control" name="dayCount" min="1" value="{{ old('dayCount',1) }}" id="dayCount" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="expired_at">مهلت پذیرش توسط پیج دار</label>
        <div class="col-xs-12 col-md-8">
            <input type="text" name="expired_at" class="form-control expired_at" autocomplete="off"
                   placeholder="*مهلت پذیرش توسط پیج دار" value="{{ old('expired_at') }}"/>
        </div>
    </div>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="ad_image">تصویر آگهی</label>
        <div class="col-xs-12 col-md-8">
            <input type="file" name="ad_image" id="ad_image" required>
        </div>
    </div>



    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label"></label>
        <div class="col-xs-12 col-md-8 ">

            <input type="submit" id="btnShowInvoice" class="btn btn-primary btn-block" value="نمایش صورتحساب">
        </div>
    </div>


</fieldset>
