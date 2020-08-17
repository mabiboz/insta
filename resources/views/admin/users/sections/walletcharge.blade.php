

    <div class="row">
        <p>شما در حال افزایش اعتبار برای کاربر
        <span class="badge">
            {{ $user->name }}
        </span>
            هستید .
        </p>
        <div style="padding: 20px;">
            <form action="{{ route('admin.user.wallet.charge',$user->id) }}" method="post">
                {{ csrf_field() }}

                <input type="hidden" required="required" class="form-control" name="user_id" value="{{$user->id}}">

                <div class="form-group">
                    <label for="amount">مبلغ به ریال :</label>
                    <input type="number" required="required" class="form-control" name="amount" placeholder="مبلغ مورد نظر را به ریال وارد نمایید ...">
                </div>



                <div class="form-group">
                    <label for="description">توضیحات :</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>

                </div>
                <button type="submit" class="btn btn-success btn-block">افزودن</button>
            </form>
        </div>
    </div>

