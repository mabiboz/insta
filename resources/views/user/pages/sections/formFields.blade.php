{{ csrf_field() }}
<div class="form-group">
    <label for="name">عنوان صفحه</label>


    <input type="text" class="form-control input-lg" id="name" value="{{ isset($page) ? $page->name : old('name','') }}"
           name="name" placeholder="عنوان صفحه ایسنتاگرام را وارد کنید...">

</div>


<div class="form-group">
    <label for="instapage_id">آدرس صفحه </label>
    <div class="input-group input-group-lg m-bot15">
        <input type="text" dir="ltr" class="form-control input-lg"  id="instapage_id" value="{{ isset($page) ? $page->instapage_id : old('instapage_id','') }}"
               name="instapage_id">
        <span class="input-group-addon">@</span>

    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="form-group">
            <label for="all_members">تعداد کل فالوورها</label>
            <input type="number" class="form-control input-lg" id="all_members"  value="{{ isset($page) ? $page->all_members : old('all_members','') }}"
                   name="all_members">
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="form-group">
            <label for="fake_members">تعداد فالوورهای فیک</label>
            <input type="number" class="form-control input-lg" id="fake_members"  value="{{ isset($page) ? $page->fake_members : old('fake_members','') }}"
                   name="fake_members">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="form-group">
            <label for="sex">جنسیت مخاطبان</label>
            <select id="sex" name="sex" class="form-control ">
                @foreach($sexPage as $key=>$value)
                    <option value="{{ $key }}"  {{  (isset($page) && $page->sex == $key) ? 'selected' : ''  }} >{{ $value }}</option>
                @endforeach

            </select>
        </div>

    </div>

    <div class="col-xs-12 col-md-6">
        <div class="form-group">
            <label for="age_contact">رده سنی مخاطبان صفحه</label>
            <select id="age_contact" name="age_contact" class="form-control ">
                @foreach($contactAge as $key=>$value)
                    <option value="{{ $key }}"  {{  (isset($page) && $page->age_contact == $key) ? 'selected' : ''  }} >{{ $value }}</option>
                @endforeach

            </select>
        </div>

    </div>
</div>

<div class="form-group">
    <label for="categorypage">دسته بندی</label>
    <select id="categorypage" name="categorypage" class="form-control">
   
        @foreach($categories as $category)
            <option value="{{ $category->id }}"  {{  (isset($page) && $page->categorypage_id == $category->id) ? 'selected' : ''  }} >{{ $category->name }}</option>
        @endforeach

    </select>
</div>

<div class="row">
    <div class="col-xs-12">
        <label for="">انتخاب حوزه جغرافیایی فعالیت صفحه</label>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <select class="form-control " name="state"
                    id="state" style="height: 44px">
                <option value="" selected class="form-control">* انتخاب استان ...
                </option>

                @foreach($allState as $state)
                    <option value="{{$state->id}}"
                            @if(old('state') == $state->id ) selected
                            @endif class="form-control">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

    </div>

</div>

<div class="form-group">
     <label for="suggestprice">قیمت پیشنهادی به تومان برای انتشار آگهی به مدت 24 ساعت :</label>

    <input type="text" class="form-control input-lg" id="suggestprice"  value="{{ isset($page) ? $page->suggestprice : old('suggestprice','') }}"
           name="suggestprice">
</div>

<div class="form-group">
    <label for="plan">نحوه پذیرش آگهی : </label>
    <select id="plan" name="plan" class="form-control">
        <option value="a" {{  (isset($page) && $page->plan == "a") ? 'selected' : ''  }}>انتشار سیستمی</option>
        <option value="b" {{  (isset($page) && $page->plan == "b") ? 'selected' : ''  }}>انتشار دستی</option>
    </select>
</div>
<ul class="well">
    <li class="alert alert-success">انتشار سیستمی : در این روش ، باید نام کاربری . رمزعبور پیج خود را در سیستم وارد نمایید و انتشار آگهی توسط سیستم در پیچ شما انجام خواهد شد .</li>
    <li class="alert alert-info">
        انتشار دستی : در این روش ، باید آگهی را دستی در پیج خود انتشار دهید و لینک آگهی را به مابینو ارسال نمایید .
    </li>
</ul>
