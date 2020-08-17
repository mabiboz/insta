@extends("layouts.user.user")


@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h3 class="alert alert-info">تنظیم مجوز ارسال خودکار آگهی ها به پیج توسط مابینو</h3>

            <form action="{{ route("user.autosend.update") }}" method="post">
                {{ csrf_field()}}
                @if($allowAutoSend)
                    <p class="alert alert-success">
                        در حال حاضر شما اجازه ارسال خودکار آگهی به پیج را به مابینو داده اید!
                    </p>
                    <label for="allow">مجوز ارسال خودکار</label>
                    <input type="checkbox" id="allow" name="allow" checked>
                @else
                    <p class="alert alert-info">
                        در حال حاضر ، مجوز ارسال خودکار آگهی ، به پیج شما برای مابینو وجود ندارد !
                    </p>
                    <label for="allow">مجوز ارسال خودکار</label>
                    <input type="checkbox" id="allow" name="allow" >
                @endif

                <button type="submit" class="btn btn-xs  btn-default btn-shadow">ثبت</button>
            </form>
        </div>
    </div>
@endsection
