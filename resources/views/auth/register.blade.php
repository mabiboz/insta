<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ثبت نام</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/calender/persian-datepicker.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link rel="stylesheet" href="/auth/style.css">
    <style>
        * {
            direction: rtl;
        }

        body {
            background-color: #00c6ff;
        }
    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>

<!------ Include the above in your HEAD tag ---------->
@include("messages.toast.validationError")
<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>به مابینو خوش آمدید </h3>

            <a href="{{ route('login') }}" style="display: inline-block;text-decoration: none;" class="btn_beautiful">ورود</a>
        </div>
        <div class="col-md-9 register-right">

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">ثبت نام</h3>
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name"
                                           placeholder=" * نام و نام خانوادگی "
                                           value="{{ old('name') }}"/>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="mobile" placeholder=" * موبایل "
                                           value="{{ old('mobile') }}"/>
                                </div>

                               <!-- <div class="form-group">
                                    <select class="form-control" name="state"
                                            id="state" style="height: 44px">
                                        <option value="" class="form-control">* انتخاب استان ...
                                        </option>
                                        @foreach($allState as $state)
                                            @if($state->id ==1)
                                                @continue
                                            @endif
                                            <option value="{{$state->id}}"
                                                    @if(old('state') == $state->id ) selected
                                                    @endif class="form-control">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>-->
                                
                                  <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="*کلمه عبور"
                                           value=""/>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="*تکرار کلمه عبور" value=""/>
                                </div>


                                <div class="form-group">
                                    <input type="text" name="birthday" class="form-control birthday" autocomplete="off"
                                           placeholder="تاریخ تولد" value="{{ old('birthday') }}"/>
                                </div>

                                <div class="form-group">

                                    <select name="education_level" id="education_level" class="form-control">
                                        <option value="0">*سطح تحصیلات را انتخاب نمایید ...</option>
                                        @foreach($educationLevels as $levelKey=>$levelValue)
                                            <option {{ old('education_level') == $levelKey ? 'selected' : ''  }} value="{{$levelKey}}">{{ $levelValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group text-right">
                                    <div class="maxl">
                                        <label class="radio inline">
                                            <input type="radio" name="sex" value="1" checked>
                                            <span> آقا </span>
                                        </label>
                                        <label class="radio inline">
                                            <input type="radio" name="sex" value="2">
                                            <span> خانم </span>
                                        </label>
                                    </div>
                                </div>
                              

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" autocomplete="off" name="email"
                                           placeholder=" ایمیل "
                                           value="{{ old('email') }}"/>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" placeholder="  تلفن ثابت "
                                           value="{{ old('phone') }}"/>
                                </div>

                                <!--<div class="form-group">-->
                                <!--    <select class="form-control" name="city"-->
                                <!--            id="city" style="height: 44px">-->
                                <!--        <option value="" class="form-control"> *انتخاب شهر ...-->
                                <!--        </option>-->

                                <!--    </select>-->
                                <!--</div>-->


                                <div class="form-group">
                               <textarea name="address" id="address" class="form-control" placeholder="*آدرس" required
                                         cols="30"
                                         rows="10">{{ old('address') }}</textarea>
                                </div>


                                <div class="form-group">
                                    @if(!is_null(\Illuminate\Http\Request::capture()->code))
                                        <input type="hidden" name="reagent" class="form-control"
                                               placeholder="کد معرف"
                                               value="{{ \Illuminate\Http\Request::capture()->code }}"/>
                                    @else
                                        <input type="text" name="reagent" class="form-control"
                                               placeholder="کد معرف"
                                               value="{{ old('reagent') }}"/>
                                    @endif

                                </div>


                                <input type="submit" class="btnRegister" value="ثبت نام"/>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<script src="/calender/persian-date.min.js"></script>
<script src="/calender/persian-datepicker.min.js"></script>
<script>
    $('.birthday').persianDatepicker({
        initialValue: false,
        format: 'L'
    });
</script>

<script>
    $('select#state').change(function () {
        var stateID = $(this).val();
        $.ajax({
            url: '/getCity',
            type: 'get',
            data: {
                stateID: stateID,
            },
            dataType: 'json',
            success: function (response) {
                var options = '';
                for (var key in response) {
                    options += "<option class='form-control' value=" + key + " >" + response[key] + "</option>"
                }
                $("select#city").html(options);
            },
            error: function () {
            },
        });
    });
</script>
</body>
</html>