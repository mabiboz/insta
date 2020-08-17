<fieldset title="گام دوم" class="step  col-xs-12 col-md-8 col-md-offset-2" id="default-step-1" style="display: none;">
    <legend>اطلاعات آگهی</legend>

    <div class="well">
        <button type="button" class="btn btn-default btn-shadow modalAjax"
                data-url="{{ route('user.campain.getDataFromFavoriteList') }}" data-id="">
            افزودن اطلاعات آگهی و کمپین از لیست علاقه مندی ها
            <span class="icon icon-plus-sign-alt"></span>
        </button>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="campain_name">نام کمپین :</label>
        <div class="col-xs-12 col-md-8">
            <input type="text" value="{{   old('campain_name','') }}" id="campain_name" class="form-control"
                   name="campain_name"
                   placeholder="نام کمپین را وارد نمایید">
        </div>
    </div>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="ad_content">توضیحات آگهی</label>
        <div class="col-xs-12 col-md-8">
            <textarea name="ad_content" placeholder="محتوا آگهی" class="form-control" id="ad_content" cols="30"
                      rows="10" style="height:200px">{{ old('ad_content','') }}</textarea>
            <p>
                <span>تعداد کارکتر باقی مانده :</span>
                <span id="countCharOfContent"></span>
            </p>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            var lengthContent = $("#ad_content").val().length;
            var len = 960 - lengthContent;
            $("#countCharOfContent").html(len);

        });

        $("#ad_content").keyup(function () {
            var x = 960;
            var y = $("#ad_content").val().length;
            var z = x - y;
            $("#countCharOfContent").html(z);
            if (z <= 0) {

            }
        });
    </script>

    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="dayCount">تعداد روز انتشار پست</label>
        <div class="col-xs-12 col-md-8">
            <select name="dayCount" id="dayCount" class="form-control" required>
                <option value="1" {{ old('dayCount') == 1 ? ' selected' : '' }}>یک روز</option>
                <option value="2" {{ old('dayCount') == 1 ? ' selected' : '' }}>دو روز</option>
                <option value="3" {{ old('dayCount') == 1 ? ' selected' : '' }}>سه روز</option>
            </select>

        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="expired_at">مهلت پذیرش توسط پیج دار</label>
        <div class="col-xs-12 col-md-8">
            <input type="text" name="expired_at" class="form-control expired_at" autocomplete="off"
                   placeholder="*مهلت پذیرش توسط پیج دار" value="{{ old('expired_at') }}"/>
        </div>
    </div>


    <input type="hidden" name="isAddDataFromFavoriteList" id="isAddDataFromFavoriteList" value="0">
    <div id="ad_file_from_favorite"></div>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label">نوع رسانه را مشخص کنید :</label>
        <div class="col-xs-12 col-md-8">
            <label for="videoType">ویدیو
                <input type="radio" name="fileType" id="videoType" value="1">
            </label>

            <label for="imageType">تصویر
                <input type="radio" name="fileType" id="imageType" value="2">
            </label>
        </div>
    </div>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="ad_image">رسانه آگهی</label>
        <div class="col-xs-12 col-md-8">
            <input type="file" name="ad_image" id="ad_image">
        </div>
    </div>

    <div class="form-group" id="coverDiv" style="display: none">
        <label class="col-xs-12 col-md-4 control-label" for="cover">کاور ویدیو</label>
        <div class="col-xs-12 col-md-8">
            <input type="file" name="cover" id="cover">
        </div>
    </div>

    <script>
        $("input[name='fileType']").click(function () {
            if ($(this).val() == 1) {
                $("#coverDiv").show();
            } else {
                $("#coverDiv").hide();

            }
        });
    </script>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label"></label>
        <div class="col-xs-12 col-md-8 ">

            <input type="button" id="btnShowInvoice" class="btn btn-primary btn-block " value="نمایش صورتحساب">


        </div>
    </div>


</fieldset>

<script>
    $("#btnShowInvoice").click(function (event) {
        

        let countPageSelected = $("#countOfPageSelectedResult").html();
        let campain_name = $("#campain_name").val();
        let ad_content = $("#ad_content").val();
        let expired_at = $("input[name='expired_at']").val();
        $.ajax({
            type: "POST",
            url: " {{ route('user.campain.ajaxValidation') }}",
            data: {
                countPageSelected: countPageSelected,
                campain_name: campain_name,
                ad_content: ad_content,
                expired_at: expired_at
            },
            success: function (response) {
                if(response['result'] == 1){
                    $(".formCreateCampain").submit();
                }else{
                    response['msgs'].forEach(function(msg){
                        toastr["error"](msg);
                        // $("#errorMessageValidationAjax").append("<p class='alert alert-danger'>"+ msg +"</p>");
                    });
                }
            },

            else: function () {

            }

        });
    });
</script>