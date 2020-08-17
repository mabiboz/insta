{{ csrf_field() }}
<div class="form-group">
    <label for="name">عنوان صفحه</label>
    <input type="text" class="form-control" id="name" value="{{ isset($page) ? $page->name : old('name','') }}"
           name="name" placeholder="عنوان صفحه ایسنتاگرام را وارد کنید...">
</div>

<div class="form-group">
    <label for="instapage_id">آدرس صفحه</label>
    <input type="text" class="form-control" id="instapage_id"  value="{{ isset($page) ? $page->instapage_id : old('instapage_id','') }}"
           name="instapage_id" placeholder="با @ شروع شود ...">
</div>

<div class="form-group">
    <label for="categorypage">دسته بندی</label>
    <select id="categorypage" name="categorypage" class="form-control m-bot15">
        <option value="0" > انتخاب دسته بندی</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"  {{  (isset($page) && $page->categorypage_id == $category->id) ? 'selected' : ''  }} >{{ $category->name }}</option>
        @endforeach

    </select>

    <div class="form-group">
        <label for="instapage_id">قیمت صفحه</label>
        <input type="number" class="form-control" id="price" name="price"  value="{{$page->price }}">
    </div>
    
      <div class="form-group">
        <label for="all_members">تعداد کل فالورها </label>
        <input type="number" class="form-control" id="all_members" name="all_members"  value="{{$page->all_members }}">
    </div>
          <div class="form-group">
        <label for="fake_members"> تعداد فالوذهای فیک  </label>
        <input type="number" class="form-control" id="fake_members" name="fake_members"  value="{{$page->fake_members }}">
    </div>
</div>
