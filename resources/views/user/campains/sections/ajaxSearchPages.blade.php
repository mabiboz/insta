<style>
    #filtersOnPage{
        float: left;
    }
    
    #filtersOnPage label{
        display: inline-block;
        margin: 20px;
    }
</style>
<div class="form-group well" id="filtersOnPage">
    <p>مرتب سازی بر اساس :</p>
    <label for="min_price">
        کمترین قیمت
        <input type="radio" name="filter" id="min_price" value="1" {{ (!is_null($filter) and $filter==1) ? " checked" : '' }}>
    </label>


    <label for="max_price">بیشترین قیمت
        <input type="radio" name="filter" id="max_price" value="2" {{ (!is_null($filter) and $filter==2) ? " checked" : '' }}>
    </label>



    <label for="min_follower">کمترین دنبال کننده
        <input type="radio" name="filter"  id="min_follower" value="3" {{ (!is_null($filter) and $filter==3) ? " checked" : '' }}>
    </label>


    <label for="max_follower" >بیشترین دنبال کننده
        <input type="radio" name="filter" id="max_follower" value="4" {{ (!is_null($filter) and $filter==4) ? " checked" : '' }}>
    </label>
</div>
<table class="table table-striped table-responsive table-hover table-bordered ">
    <thead>
    <tr>
        <th>انتخاب</th>
        <th>ردیف</th>
        <th>عنوان صفحه</th>
        <th>آدرس</th>
        <th>تعداد دنبال کننده</th>
        <th>قیمت
            <span style="font-size:10px">(تومان)</span>
        </th>
    </tr>
    </thead>

    <tbody>
    @foreach($pages as $page)
        <tr>
            <td>
                <input type='checkbox' class="pageCheckBoxSelect" name='pages_id[]' data-price="{{ $page->price }}"
                       data-allmembers="{{ $page->all_members }}"
                       value="{{ $page->id }}">
            </td>
            <td>
                {{ $loop->iteration }}
            </td>
            <td>{{ $page->name }}</td>
            <td> <a target="_blank"
                    href="https://www.instagram.com/{{ str_replace("@","",$page->instapage_id) }}">
                    {{ $page->instapage_id }}
                </a></td>
            <td>{{ $page->all_members }}</td>
            <td>{{ number_format($page->price) }}</td>
        </tr>
    @endforeach
    <tr style="background-color: #1c94c4">
        <td colspan="4">مجموع قیمت و تعداد دنبال کنندگان : </td>
        <td id="fullMembers">

        </td>
        <td id="fullPricePage">

        </td>
    </tr>
    </tbody>
</table>



<script>




    $(".pageCheckBoxSelect").change(function () {

        if ($(this).is(":checked")) {
            window.fullPrice += parseInt($(this).data('price'));
            window.fullMembers += parseInt($(this).data('allmembers'));
        } else {
            window.fullPrice -= parseInt($(this).data('price'));
            window.fullMembers -= parseInt($(this).data('allmembers'));
        }


        $("#fullPricePage").html( numeral(window.fullPrice).format('0,0')  + " تومان");
        $("#fullMembers").html(window.fullMembers);

        $("#fullPricePage2").html( numeral(window.fullPrice).format('0,0')  );
        $("#fullMembers2").html(window.fullMembers);

        $("#countOfPageSelectedResult").html($(".pageCheckBoxSelect:checked").length);

    });

</script>


<script>
    $("input[name='filter']").on('click', function (event) {
        let category_id = $("#category_page").val();
        let province_id = $("#province_id").val();
        let age_contact = $("#age_contact").val();
        let sexPage = $("#sex").val();
        let filter = $(this).val();

        $.ajax({
            type: "POST",
            url: " {{ route('user.campain.getPages') }}",
            data: {
                category_id: category_id,
                province_id: province_id,
                age_contact: age_contact,
                sexPage: sexPage,
                filter:filter,

            },
            success: function (response) {
                $("#countOfPageSelectedResult").html(0);
                $("#fullMembers2").html(0);
                $("#fullPricePage2").html(0);

                $("#pageListSection").html("");
                if (response['result']) {
                    $("#selectAllPageLabel").slideDown();
                    $("#pageListSection").append(response['content']);
                    $("#countOfPageSearchResult").html($(".pageCheckBoxSelect").length);

                } else {
                    $("#pageListSection").html("هیچ صفحه ای یافت نشد.");
                }


            }

        });
    });
</script>

