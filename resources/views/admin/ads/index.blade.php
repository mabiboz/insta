@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    لیست صفحات

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="hidden-phone"><i class="icon-question-sign"></i>عنوان</th>
                        <th><i class=" icon-tags"></i>آدرس صفحه</th>
                        <th><i class="icon-bookmark"></i>دسته بندی</th>
                        <th><i class=" icon-edit"></i>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->name }}</td>
                            <td>{{ $page->instapage_id }}</td>
                            <td>{{ $page->categoryPage->name }}</td>
                            <td>
                                @if($page->status == \App\Models\Page::ACTIVE)
                                    <span class="label label-success label-mini">فعال</span>

                                @else
                                    <span class="label label-danger label-mini">غیرفعال</span>

                                @endif
                            </td>
                            <td>
                                <a href="{{ route("user.pages.edit",$page) }}" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                <!--<a  href="{{ route("user.pages.delete",$page) }}"-->
                                <!--    onclick="return confirm('آیا برای حذف مطمئن هستید ؟');"-->
                                <!--    class="btn btn-danger btn-xs"><i class="icon-trash "></i></a>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
