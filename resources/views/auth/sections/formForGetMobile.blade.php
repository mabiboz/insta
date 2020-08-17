<input name="mobile" id="mobileForResetPassword"  class="form-control" placeholder="شماره موبایل را وارد نمایید ...">
<button class="ajaxModal2 btn btn-info btn-block" data-url="{{ route('resetPassword.getMobile') }}"  id="btnGetMobile">ارسال</button>

<script>
    $(".ajaxModal2").click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var mobile = $("#mobileForResetPassword").val();

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
                    mobile: mobile,
                },

                success: function (response) {
                    $("#modalResetPassword .modal-body").html(response);
                    $("#modalResetPassword").modal("show");

                },
            });
    })
</script>