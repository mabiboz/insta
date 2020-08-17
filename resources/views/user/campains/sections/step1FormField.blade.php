<fieldset title="گام اول" class="step col-xs-12 col-md-8 col-md-offset-2" id="default-step-0">
    <legend class="title"><span>انتخاب صفحات اینستاگرام</span></legend>


    <div class="form-group" style="display:none">
        <label class="col-xs-12 col-md-4 control-label" for="province_id">محدوده جغرافیایی فعالیت صفحه :</label>
        <div class="col-xs-12 col-md-8">
            <select class="form-control m-bot15" required id="province_id" name="province_id">
                <option value="0">انتخاب استان</option>
                @foreach($provinces as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>




    <!-- -------------------------------------------------------------------------
    |                             START New Form                                |
    ------------------------------------------------------------------------- -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="mb-4 control-label" for="category_page">انتخاب دسته بندی صفحات :</label>
                <select class="form-control m-bot15" required id="category_page" name="category_page">
                
                    @foreach($categoriesPage as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="mb-4 control-label" for="sex">انتخاب جنسیت مخاطبین :</label>
                <select class="form-control m-bot15" required id="sex" name="sex">

                    @for($i=count($sexPage)-1;$i>=0;$i--)
                        <option value="{{ $i }}">{{ $sexPage[$i] }}</option>
                    @endfor

                </select>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------------------
    |                              End New Form                                 |
    --------------------------------------------------------------------------->

    <!-- <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="category_page">انتخاب دسته بندی صفحات :</label>
        <div class="col-xs-12 col-md-8">
            <select class="form-control m-bot15" required id="category_page" name="category_page">
               
                @foreach($categoriesPage as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="form-group">
        <label class="col-xs-12 col-md-4 control-label" for="sex">انتخاب جنسیت مخاطبین :</label>
        <div class="col-xs-12 col-md-8">
            <select class="form-control m-bot15" required id="sex" name="sex">

                @for($i=count($sexPage)-1;$i>=0;$i--)
                    <option value="{{ $i }}">{{ $sexPage[$i] }}</option>
                @endfor

            </select>
        </div>
    </div> -->






    <div class="form-group"  style="display:none">
        <label class="col-xs-12 col-md-4 control-label" for="age_contact">انتخاب محدوده سنی مخاطبین :</label>
        <div class="col-xs-12 col-md-8">
            <select class="form-control m-bot15" required id="age_contact" name="age_contact">

                @foreach($contactAge as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- <label class="col-xs-12 col-md-4 control-label"></label> -->
    <div>
        <button type="button" class="btn btn-success" id="btnSearchPages">جستجو صفحات
            <span class="glyphicon glyphicon-search"></span>
        </button>
    </div>

    <section class="row">
        <div class="col-xs-12">
            <div>
                <p class="label-sum">نتیجه جستجوی شما <span class="badge-custom" id="countOfPageSearchResult">0</span> صفحه اینستاگرام</p>
                <p class="label-sum">تعداد صفحه انتخابی شما <span class="badge-custom" id="countOfPageSelectedResult">0</span> صفحه
                    اینستاگرام</p>
                <p class="label-sum">مجموع قیمت <span class="badge-custom" id="fullPricePage2">0</span> تومان</p>
                <p class="label-sum">مجموع دنبال کننده ها <span class="badge-custom" id="fullMembers2">0</span> نفر</p>
            </div>
        </div>
    </section>



    <label class='label_check c_off' style="display: none;" id="selectAllPageLabel">
        <span class="icon-reply-all"></span>
        <input id='selectAllPageCheckBox' type='checkbox'/>انتخاب همه </label>
    <ul id="pageListSection">
    </ul>


    <br>
    <br>
    <br>


</fieldset>





