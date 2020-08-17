<section class="panel">
    <header class="panel-heading">
        @if(isset($category) )
            ویرایش دسته بندی
        @else
            ایجاد دسته بندی جدید
        @endif

    </header>
    <form action="{{ isset($category) ? route("admin.categoryPage.update",$category) : route('admin.categoryPage.store') }}"
          method="post" class="form-inline alert alert-info">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="name"
                   id="name" class="form-control"
                   value="{{ isset($category) ? $category->name : '' }}"
                   placeholder="عنوان دسته بندی">
        </div>
        <div class="form-group">
            @if(isset($category))
                <button type="submit" class="btn btn-warning">ویرایش</button>
            @else
                <button type="submit" class="btn btn-primary">ثبت</button>
            @endif
        </div>
    </form>
</section>