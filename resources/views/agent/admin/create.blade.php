@extends("layouts.user.user")

@section("top_css")
    <link rel="stylesheet" href="/calender/persian-datepicker.min.css">
@endsection

@section("bottom_js")
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
                url: '{{ route("agent.admin.getCity") }}',
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

    <script>
        $("#plotId .header-row-cell").css("display","none");
    </script>
    <script>
        $(".birthday").change(function() {
            $("#plotId .header-row-cell").css("display","none");
        });
    </script>
@endsection



@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h3 class="alert alert-info">ثبت ادمین جدید</h3>

            <form action="{{ route("agent.admin.store") }}" method="post">
                @include("agent.admin.sections.formFields")
                <button type="submit" class="btn btn-primary">ثبت</button>
            </form>
        </div>
    </div>
@endsection
