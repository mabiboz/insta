<section class="panel" id="newNewsForm" style="display: none;">

    <form action="{{ route('admin.news.store') }}"
          method="post" class="alert alert-info" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="title"
                   id="title" class="form-control"
                   value="{{ old('title') }}"
                   placeholder="عنوان خبر">
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="محتوای خبر*" id="content" cols="30"
                      rows="10">{{ old('content') }}</textarea>

        </div>

        <div class="form-group">
            <input type="file" name="image"
                   id="image"
            >
        </div>
        <div class="form-group">

            <button type="submit" class="btn btn-primary">ثبت</button>
        </div>
    </form>
</section>