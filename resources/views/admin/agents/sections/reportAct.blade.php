<table class="table table-bordered table-responsive table-striped table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>عنوان صفحه</th>
        <th>عنوان کمپین</th>
        <th>سود دریافتی</th>
    </tr>
    </thead>

    <tbody>
    @foreach($pageRequests as $pageID=>$items)
        @foreach($items as $item)
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->page->name }}</td>
              <td>{{ $item->ad->campain->title }}</td>
              <td>{{ getRatio($item->ad->day_count) * $item->page->price * 0.1 }}</td>
          </tr>
        @endforeach
    @endforeach
    </tbody>

</table>