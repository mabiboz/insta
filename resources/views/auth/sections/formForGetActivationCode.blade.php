<input type="text" name="activation_code"  id="activation_code_reset"  class="form-control " placeholder="کد اعتبار سنجی">
<button class="ajaxModal3 btn btn-info btn-block" data-url="{{ route('resetPassword.verifyMobile') }}">تایید</button>
<script>
    $(".ajaxModal3").click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var data = $("#activation_code_reset").val();
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