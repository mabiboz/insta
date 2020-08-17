@extends("layouts.user.user")

@section("top_css")
    <link rel="stylesheet" href="/calender/persian-datepicker.min.css">


@endsection


@section("bottom_js")
    <script src="/calender/persian-date.min.js"></script>
    <script src="/calender/persian-datepicker.min.js"></script>
    <script>
        $('.expired_at').persianDatepicker({
            initialValue: false,
            format: 'L'
        });
    </script>

    <script src="/calender/persian-date.min.js"></script>
    <script src="/calender/persian-datepicker.min.js"></script>
    <script>
        $('.expired_at').persianDatepicker({
            initialValue: false,
            format: 'L'
        });
    </script>

    <!--script for this page-->
    <script src="/mabino/js/jquery.stepy.js"></script>


    <script>

        //step wizard

        $(function () {
            $('#default').stepy({
                backLabel: 'برگشت',
                block: true,
                nextLabel: 'بعدی',
                titleClick: true,
                titleTarget: '.stepy-tab',
                finishButton: false,
                finish: 'پایان',

            });
        });
    </script>

    <script>


        $(document).ready(function () {
            $("#default-titles").append(
                "       <li id='default-title-2' onclick='alert(\"برای نمایش صورت حساب ، ابتدا آگهی ثبت نمایید !\")' style='margin-right: 52px'>" +
                "            <div>گام سوم</div>" +
                "            <span>نمایش صورت حساب</span></li>"
            );
        });


    </script>


    <script>
        $("#btnSearchPages").on('click', function (event) {
            event.preventDefault();
            let category_id = $("#category_page").val();
            let province_id = $("#province_id").val();
            let age_contact = $("#age_contact").val();
            let sexPage = $("#sex").val();

            $.ajax({
                type: "POST",
                url: " {{ route('user.campain.getPages') }}",
                data: {
                    category_id: category_id,
                    province_id: province_id,
                    age_contact: age_contact,
                    sexPage: sexPage,
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


    <script>
      window.fullPrice =0;
      window.fullMembers=0;
        $("#selectAllPageCheckBox").change(function () {

            let allSelected = $("#selectAllPageCheckBox").is(":checked");
          
            if (allSelected) {

                $("#pageListSection input[type='checkbox']").prop("checked", true);
                $("#pageListSection input[type='checkbox']").each(function(key,item){
                    window.fullPrice += parseInt($(this).data('price'));
                    window.fullMembers += parseInt($(this).data('allmembers'));
                });

            } else {
                $("#pageListSection input[type='checkbox']").prop("checked", false);
                   window.fullPrice =0
                    window.fullMembers =0;

            }
            $("#fullPricePage").html( numeral(window.fullPrice).format('0,0') + " تومان");
            $("#fullMembers").html( window.fullMembers);
            $("#fullPricePage2").html(  numeral(window.fullPrice).format('0,0'));
            $("#fullMembers2").html( window.fullMembers);
            $("#countOfPageSelectedResult").html($(".pageCheckBoxSelect:checked").length);

        });
    </script>
<script>
    $("#amirabbasbtn").click(function(){
        
        $("#default-step-0").css('display','none');
        $("#default-title-0").removeClass('current-step');
          $("#default-title-1").addClass('current-step');
         $("#default-step-1").css('display','block');
            $("#amirabbasbtn").css('display','none');
        
    });
</script>




@endsection

@section("content")
    @include("user.campains.sections.modal")
    <div class="row" style="zoom:100%">
        <div class="col-xs-12 ">
            <p class="alert alert-info">ایجاد کمپین جدید</p>

            <div class="panel-body">
                @include("user.campains.sections.stepTab")
                <form method="post" action="{{ route('user.campain.invoice') }}" class="form-horizontal formCreateCampain" id="default"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @include("user.campains.sections.step1FormField")
                    @include("user.campains.sections.step2FormField")
                    {{--                    @include("user.campains.sections.step3FormField")--}}


                </form>

            </div>


        </div>
    </div>
@endsection
