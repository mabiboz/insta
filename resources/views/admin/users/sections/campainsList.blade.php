

<script src="/mabino/js/jquery.scrollTo.min.js"></script>
<script src="/mabino/js/jquery.nicescroll.js" type="text/javascript"></script>


<script>
    $(".modal").modal({show:false, backdrop:false})
</script>
<!--common script for all pages-->
<script src="/mabino/js/common-scripts.js"></script>


{{--loading when use ajax--}}
<script src="/mabino/js/loading.js"></script>
<link rel="stylesheet" href="/mabino/css/loading.css">

{{--show modal with ajax--}}
<script>
    $(".modalAjaxShowPagesOfCampains").click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            type:"POST",
            url : url,
            data:{
                id:id,
            },
            success:function (response) {
                $("#ajaxModal .modal-body").html(response);
                $("#ajaxModal").modal("show");

            }
        });

    });
</script>

{{--show modal with ajax--}}
<script>
    $(".modalAjaxRequest").click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var id = $(this).data('id');
        var pageid = $(this).data('pageid');
        $.ajax({
            type:"POST",
            url : url,
            data:{
                id:id,
                pageid:pageid,
            },
            success:function (response) {
                $("#ajaxModalForRequest .modal-body").html(response);
                $("#ajaxModalForRequest").modal("show");

            }
        });

    });
</script>


<style>
    .modalAjax{
        cursor: pointer;
    }
</style>



<div class="row">
        @include("user.campains.sections.modal")

        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست کمپین ها

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="icon-question-sign"></i>عنوان</th>
                        <th>تعداد صفحات</th>
                        <th>لیست صفحات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campains as $campain)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $campain->title }}</td>
                            <td><span class="badge">{{ count($campain->pages) }}</span></td>
                            <td><span class="icon icon-list modalAjaxShowPagesOfCampains"  data-url="{{ route('admin.user.campain.getCampainPagesAjax',['id'=>$campain->id, 'userid'=>$campain->user->id] ) }}" data-id="{{ $campain->id }}"></span></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>

<script src="/js/modalAjax.js"></script>