<div class="row text-center">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-warning">
            <p>
                کاربر گرامی ، ثبت نام شما با موفقیت انجام شد . برای استفاده از امکانات سایت کد پیامک شده را وارد
                نمایید !
            </p>
            <div class="row" style="margin-top: 20px">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <form action="{{ route("user.activation") }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="code">
                        <input type="submit" value="تایید" class="btn btn-default btn-sm">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>