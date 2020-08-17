<div class="row">
    @include("admin.agents.sections.modal")


    <section class="panel">
        <header class="panel-heading">
            لیست زیرمجموعه
        </header>
        <table class="table  table-advance table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>موبایل</th>
                <th>تلفن ثابت</th>
                <th>ایمیل</th>
                <th>تاریخ ایجاد</th>
                <th>جنسیت</th>
                <th>تعداد صفحات</th>
              

            </tr>
            </thead>
            <tbody>
            @if(!is_null($admins))
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->mobile }}</td>
                        <td>{{ $admin->phone }}</td>
                        <td>{{ $admin->email }}</td>

                        <td>{{jdate($admin->created_at)->format(" Y-m-d H:i")}}  </td>
                        <td>
                            @if($admin->sex == 1)
                                <span class="label label-success label-mini">مرد</span>

                            @else
                                <span class="label label-danger label-mini">">زن</span>

                            @endif

                        </td>



                        <td><span class="badge">{{$admin->pages->count()}}</span></td>
                       

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">هیچ ادمینی یافت نشد !</td>
                </tr>
            @endif
            </tbody>
        </table>
    </section>
</div>