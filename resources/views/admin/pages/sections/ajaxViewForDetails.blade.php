<table class="table table-hover table-hover table-bordered table-responsive table-striped">
    <tr>
        <td>جنسیت مخاطب</td>
        <td>{{ $pageSex[$page->sex] }}</td>
    </tr>

    <tr>
        <td>رده سنی مخاطب</td>
        <td>{{ $ageContact[$page->age_contact] }}</td>
    </tr>

    <tr>
        <td>تعداد کل فالوورها</td>
        <td>{{ $page->all_members }}</td>
    </tr>

    <tr>
        <td>تعداد فالوورهای فیک</td>
        <td>{{ $page->fake_members }}</td>
    </tr>

    <tr>
        <td>حوزه جغرافیایی فعالیت</td>
        <td>{{ $page->city->name  }}</td>
    </tr>
</table>

@if(count($page->pagesLastVersion))
    <h3>اطلاعات آخرین نسخه صفحه</h3>
    <table class="table table-hover table-hover table-bordered table-responsive table-striped">
        <tr>
            <td>جنسیت مخاطب</td>
            <td>{{ $pageSex[$page->pagesLastVersion()->latest()->first()->sex] }}</td>
        </tr>

        <tr>
            <td>رده سنی مخاطب</td>
            <td>{{ $ageContact[$page->pagesLastVersion()->latest()->first()->age_contact] }}</td>
        </tr>

        <tr>
            <td>تعداد کل فالوورها</td>
            <td>{{ $page->pagesLastVersion()->latest()->first()->all_members }}</td>
        </tr>

        <tr>
            <td>تعداد فالوورهای فیک</td>
            <td>{{ $page->pagesLastVersion()->latest()->first()->fake_members }}</td>
        </tr>

        <tr>
            <td>قیمت قبلی</td>
            <td>{{ $page->pagesLastVersion()->latest()->first()->price  }}</td>
        </tr>
    </table>
@endif