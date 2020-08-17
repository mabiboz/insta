@extends('layouts.user.user')

@section('bottom_js')
    <script>
        $("#copyCode").click(function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($("#code").text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('#flash').delay(500).fadeIn('normal', function () {
                $(this).delay(2500).fadeOut();
            });
        });
    </script>

    <script>
        $("#copyLink").click(function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).data('link')).select();
            document.execCommand("copy");
            $temp.remove();
            $('#flash2').delay(500).fadeIn('normal', function () {
                $(this).delay(2500).fadeOut();
            });
        });
    </script>
@endsection

@section('content')

    <div id="app">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">کد اختصاصی شما</div>
                        <div class="panel-body text-center">
                            <h1 id="code" dir="ltr">
                                {{ $code }}

                            </h1>

                            <button id="copyCode" title="copy" class="btn btn-success">
                                <span class="fa fa-copy"></span>
                            </button>
                            <p class="badge" id="flash" style="display: none">کد اختصاصی کپی شد !</p>

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 text-center">
                    <button class="btn btn-default btn-shadow" id="copyLink"
                            data-link="{{ route('registerWithLinkFromAgent',$code) }}">کپی لینک ثبت نام نمایندگی
                    </button>
                    <p class="badge" id="flash2" style="display: none">لینک ثبت نام کپی شد !</p>

                </div>
            </div>

        </section>
    </div>
    <div style="clear:both;"></div>



@endsection

