@extends('layouts.app')
@section("top-css")
    <link rel="stylesheet" href="/calender/persian-datepicker.min.css">

@endsection


@section("bottom-js")
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
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">نام</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-4 control-label">موبایل</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="text" class="form-control" name="mobile"
                                           value="{{ old('mobile') }}" required>

                                    @if ($errors->has('mobile'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">تلفن ثابت</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone"
                                           value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('education_level') ? ' has-error' : '' }}">
                                <label for="education_level" class="col-md-4 control-label">سطح تحصیلات</label>

                                <div class="col-md-6">
                                    <select name="education_level" id="education_level" class="form-control">
                                        <option value="0">سطح تحصیلات را انتخاب نمایید ...</option>
                                        @foreach($educationLevels as $levelKey=>$levelValue)
                                            <option value="{{$levelKey}}">{{ $levelValue }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('education_level'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('education_level') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                <label for="sex" class="col-md-4 control-label">جنسیت</label>

                                <div class="col-md-6">

                                    <input type="radio" name="sex" value="1">مرد
                                    <input type="radio" name="sex" value="1">زن

                                    @if ($errors->has('sex'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('sex') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">ایمیل</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <label for="birthday" class="col-md-4 control-label">تاریخ تولد</label>

                                <div class="col-md-6">
                                    <input type="text" name="birthday" class="birthday form-control" required
                                           value="{{ old('birthday') }}">
                                    @if ($errors->has('birthday'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">آدرس</label>

                                <div class="col-md-6">
                                    <textarea name="address" id="address" class="form-control" required cols="30"
                                              rows="10">{{ old('address') }}</textarea>


                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                <label for="state" class="col-md-4 control-label">استان</label>

                                <select class="form-control" name="state"
                                        id="state" style="height: 44px">
                                    <option value="" class="form-control"> انتخاب استان ...
                                    </option>
                                    @foreach($allState as $state)
                                        <option value="{{$state->id}}"
                                                @if(old('state') == $state->id ) selected
                                                @endif class="form-control">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state'))
                                    <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('state') }}
                                       </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="city" class="col-md-4 control-label">شهر</label>

                                <select class="form-control" name="city"
                                        id="city" style="height: 44px">
                                    <option value="" class="form-control"> انتخاب شهر ...
                                    </option>

                                </select>
                                @if ($errors->has('city'))
                                    <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('city') }}
                                       </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('reagent') ? ' has-error' : '' }}">
                                <label for="reagent" class="col-md-4 control-label">کدمعرف</label>

                                <div class="col-md-6">
                                    <input id="reagent" type="text" class="form-control" name="reagent" >

                                    @if ($errors->has('reagent'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reagent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">کلمه عبور</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">تکرار کلمه عبور</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
