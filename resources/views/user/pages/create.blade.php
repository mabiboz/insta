@extends("layouts.user.user")


@section("content")
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h3 class="alert alert-info">درج صفحه جدید</h3>
            <p class="alert alert-warning">
                ادمین عزیز لطفا اطلاعات مربوط به صفحه اینستاگرام خود را به صورت واقعی اعلام نمایید . میزان فالوورهای صفحات شما از لحاظ تعداد فیک ، توسط کارشناسان مابینو بررسی می گردد و درصورت وجود مغایرت ،صفحه شما تایید نمی گردد .(ادمین های عزیز پیج ها به صورت دقیق بررسی میگردند , مابینو برای کسب درآمد صحیح است , به این فکر کنید کسی که تبلیغ میدهد انتظار دارد از تبلیغاتش بازخورد خوبی دریافت کند, لطفا در مابینو اطلاعات واقعی خود را وارد کنید تا مابینو صفحات شما را تایید کند ,ما را با صداقت خود همراهی کنید. ) با سپاس از همراهی شما
            </p>
<P>
ادمین های عزیز چنانچه اطلاعات صفحات شما درست نباشد مابینو میزان تقریبی فالور فیک شما را محاسبه و از میزان اعلامی کسر میکند و بر اساس میزان فالور واقعی صفحات شما را قیمت گذاری میکند
</p>
            <form action="{{ route("user.pages.store") }}" method="post">
                @include("user.pages.sections.formFields")
                <button type="submit" class="btn btn-primary">ثبت</button>
            </form>
        </div>
    </div>
@endsection
