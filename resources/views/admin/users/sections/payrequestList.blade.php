<script src="/mabino/js/jquery.scrollTo.min.js"></script>
<script src="/mabino/js/jquery.nicescroll.js" type="text/javascript"></script>


<script>
    $(".modal").modal({show: false, backdrop: false})
</script>
<!--common script for all pages-->
<script src="/mabino/js/common-scripts.js"></script>


{{--loading when use ajax--}}
<script src="/mabino/js/loading.js"></script>
<link rel="stylesheet" href="/mabino/css/loading.css">


<style>
    .modalAjax {
        cursor: pointer;
    }
</style>


<div class="row">
    @include("user.campains.sections.modal")

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                لیست درخواست ها

            </header>
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th><i class="icon-question-sign"></i>
                        مبلغ
                        <span style="font-size: 10px">(تومان)</span>

                    </th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>

                </tr>
                </thead>
                <tbody>
                @if(count($payrequests))
                    @foreach($payrequests as $payrequest)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payrequest->amount }}</td>
                            <td><span class="label
                         label-{{ ($payrequest->status == \App\Models\PayRequest::PENDING) ? 'warning' : 'success'}}
                                        label-mini">

                                    @if($payrequest->status==\App\Models\PayRequest::PENDING)
                                        {{ 'درخواست معلق' }}
                                    @else
                                        {{ 'پرداخت شده' }}
                                    @endif

                             </span></td>
                            <td>
                                @php
                                    $jdf =new \App\Jdf();
                                @endphp
                                {{  getjalaliDate($payrequest->created_at) }}
                            </td>

                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="4">
                            هیچ درخواستی یافت نشد !
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </div>
</div>

