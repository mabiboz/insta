<div class="row">
    <div class="col-xs-12">
        <form method="post" action="{{ route('admin.user.update',$user) }}">
            {{ csrf_field() }}


            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="name"> نام و نام خانوادگی : </label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input type="text" class="form-control" name="name"
                               placeholder=" * نام و نام خانوادگی "
                               value="{{ $user->name }}"/>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="birthday">تاریخ تولد :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input type="text" name="birthday" class="form-control birthday" autocomplete="off"
                               placeholder="*تاریخ تولد" value="{{ $user->birthday }}"/>
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="education_level">سطح تحصیلات :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <select name="education_level" id="education_level" class="form-control">
                            <option value="0">*سطح تحصیلات را انتخاب نمایید ...</option>
                            @foreach($educationLevels as $levelKey=>$levelValue)
                                <option {{ $user->education_level == $levelKey ? 'selected' : ''  }} value="{{$levelKey}}">{{ $levelValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="form-group text-right">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label>جنسیت :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <div class="maxl">
                            <label class="radio inline">
                                <input type="radio" name="sex" value="1" {{ $user->sex == 1 ? ' checked' :'' }}>
                                <span> آقا </span>
                            </label>
                            <label class="radio inline">
                                <input type="radio" name="sex" value="2" {{ $user->sex == 2 ? ' checked' :'' }}>
                                <span> خانم </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="password">کلمه عبور :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input type="password" class="form-control" autocomplete="off" name="password" id="password"
                               placeholder="*کلمه عبور"
                        />
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="email">ایمیل :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <input type="email" class="form-control" autocomplete="off" name="email"
                               placeholder="* ایمیل "
                               value="{{ $user->email }}"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="phone">تلفن ثابت :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input type="text" class="form-control" name="phone" placeholder=" * تلفن ثابت "
                               value="{{ $user->phone }}"/>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="address">آدرس :</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                   <textarea name="address" id="address" class="form-control" placeholder="*آدرس" required
                             cols="30"
                             rows="10">{{ $user->address }}</textarea>
                    </div>
                </div>
            </div>



            <input type="submit" class="btn btn-shadow btn-info btn-block" value="به روز رسانی"/>

        </form>
    </div>
</div>
<script>
    $('.birthday').persianDatepicker({
        initialValue: false,
        format: 'L'
    });
</script>