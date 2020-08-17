@if(count($favorites))
    <table class="table table-bordered table-hover table-responsive table-responsive">
        <thead>
        <tr>
            <th>نام کمپین</th>
            <th>محتوای آگهی</th>
            <th>فایل آگهی</th>
            <th>انتخاب</th>
        </tr>
        </thead>
        <tbody>
        @foreach($favorites as $fav)
            <tr>
                <td>{{ $fav->campain_name }}</td>
                <td>{{ $fav->summaryOfAdContent }}</td>
                <td><img src="{{ config("UploadPath.ad_image_path").$fav->ad_file }}" width="200" class="img-responsive"></td>
                <td>
                    <button class="btn btn-shadow btn-xs btn-default btnAddDataFavCampainToForm" data-favid="{{ $fav->id }}">
                        <span class="icon icon-plus"></span>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else

@endif

<script>
    $(".btnAddDataFavCampainToForm").click(function(event){
        event.preventDefault();

        var favid = $(this).data('favid');
        $.ajax({
            type:"POST",
            url:"{{ route('user.campain.getDataFromFavoriteListAndPutToForm') }}",
            data:{
                favid:favid,
            },
            success:function (response) {
                $("#ajaxModal").modal("hide");
                $("#campain_name").val(response['campain_name']);
                $("#ad_content").val(response['ad_content']);
                var countChar = 960 - response['ad_content'].length;
                $("#countCharOfContent").html(countChar);
                var filePath = "/uploads/ads/images/" + response['ad_file'];
                $("#ad_file_from_favorite").html("<img width='200' class='img-responsive' src="+filePath+">");
                $("#isAddDataFromFavoriteList").val(response['id']);
            }
        });
    });
</script>