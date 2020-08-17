<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ثبت نام</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link rel="stylesheet" href="/auth/style.css">
    <style>
        * {
            direction: rtl;

        }
    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        body {
            background-color: #00c6ff;
        }
    </style>
    <link rel="stylesheet" href="/mabino/css/loading.css">
</head>
<body>

<div id="wait" class="loading" style="display: none;">
    <img src="/mabino/assets/jquery-file-upload/img/loading.gif" alt="">
</div>
<div id="overlay" class="overlay" style="display: none;"></div>

<!------ Include the above in your HEAD tag ---------->
@include("messages.toast.validationError")
@include("auth.sections.modalResetPassword")

@if(!is_null(session('resetPasswordSuccess')))
    <script>
        toastr.success("{{ session('resetPasswordSuccess') }}");
    </script>
@endif

@if(!is_null(session('resetPasswordError')))
    <script>
        toastr.error("{{ session('resetPasswordError') }}");
    </script>
@endif

<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>به مابینو خوش آمدید </h3>

            <a href="{{ route('register') }}" style="display: inline-block;text-decoration: none;"
               class="btn_beautiful">ثبت نام</a>
        </div>
        <div class="col-md-9 register-right">

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">ورود</h3>
                        <div class="row register-form">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="mobile"
                                           placeholder=" *نام کاربری(شماره موبایل) "
                                           value="{{ old('mobile') }}"/>
                                </div>
                            </div>


                            <div class="col-md-4 ">

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password"
                                           placeholder="*کلمه عبور"
                                           value=""/>
                                </div>
                            </div>

                            <div class="col-md-4 ">

                                <input type="submit" class="btnRegister" value="ورود"/>
                            </div>


                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12" style="padding-right: 85px">
                        <button id="forgetPasswordBtn" class="ajaxModal btn btn-default btn-sm"
                                data-url="{{ route('resetPassword.showFormGetMobile') }}" data-data=""
                        >فراموشی کلمه عبور
                        </button>

                    </div>
                </div>

            </form>


        </div>
    </div>

</div>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


<script src="/mabino/js/loading.js"></script>

<script>
    $(".ajaxModal").click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var data = $(this).data('data');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
            {
                url: url,
                type: 'GET',
                data: {
                    data: data,
                },

                success: function (response) {
                    $("#modalResetPassword .modal-body").html(response);
                    $("#modalResetPassword").modal("show");

                },
            });
    })
</script>

</body>
</html>