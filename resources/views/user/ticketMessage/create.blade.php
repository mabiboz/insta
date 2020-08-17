@extends("layouts.user.user")


@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            
            
            <h3 class="alert alert-info">درج تیکت جدید</h3>
            <!--<p class="alert alert-warning">-->
            <!--    به دلیل بروزرسانی سیستم تیکت ، تا اطلاع ثانوی امکان درج تیکت وجود ندارد !-->
            <!--</p>-->

           <form action="{{ route("user.ticket.store") }}" method="post">
                @include("user.ticketMessage.sections.formFields")
                <button type="submit" class="btn btn-primary">ثبت</button>
            </form>
        </div>
    </div>
@endsection
