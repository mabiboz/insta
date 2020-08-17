{{ csrf_field() }}

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

        <div class="form-group">
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
        </div>

        <div class="form-group">
            <input type="text" name="birthday" class="form-control birthday" autocomplete="off"
                   placeholder="*تاریخ تولد" value="{{ old('birthday') }}"/>
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
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="*کلمه عبور"
                   value=""/>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation"
                   placeholder="*تکرار کلمه عبور" value=""/>
        </div>


    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input type="email" class="form-control" autocomplete="off" name="email"
                   placeholder="* ایمیل "
                   value="{{ old('email') }}"/>
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder=" * تلفن ثابت "
                   value="{{ old('phone') }}"/>
        </div>

        <div class="form-group">
            <select class="form-control" name="city"
                    id="city" style="height: 44px">
                <option value="" class="form-control"> *انتخاب شهر ...
                </option>

            </select>
        </div>


        <div class="form-group">
                               <textarea name="address" id="address" class="form-control" placeholder="*آدرس" required
                                         cols="30"
                                         rows="10">{{ old('address') }}</textarea>
        </div>


    </div>
</div>
