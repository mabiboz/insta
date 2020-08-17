<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                لیست آگهی های ثبت شده توسط مابینو
            </header>
            <table class="table table-bordered table-advance table-hover">
                <thead>

                <tr>
                    <th>#</th>
                    <th>محتوا متنی</th>
                    <th>رسانه تصویری</th>
                    <th>تغییر وضعیت</th>
                    <th>مربوط به مابینو</th>
                  <th>عملیات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($ads as $item)
                    <tr class="alert {{ $item->status == \App\Models\Ad::OK ? ' alert-success' : ' alert-danger' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->content }}</td>
                        <td>
                            @if(strlen($item->images->first()))
                                @if(getMediaAccordingType($item->images->first()->name) == "image")
                                    <img src="{{ config('UploadPath.ad_image_path').$item->images->first()->name  }}"
                                         alt="" height="100" width="150"
                                         class="img-circle img-responsive img-thumbnail">
                                @else
                                    <video src="{{ config('UploadPath.ad_image_path').$item->images->first()->name  }}"
                                           controls height="100" width="100" preload="none"
                                    ></video>
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.newAdFromMabino.changeStatus',$item->id) }}" class="btn btn-warning btn-xs">
                                <span class="fa fa-edit"></span>
                            </a>
                        </td>

                        <td>
                            @if($item->is_mabinoe)
                                <button class="btn btn-xs btn-success btn-shadow">
                                    <span class="glyphicon glyphicon-ok"></span>

                                </button>
                            @else
                                <button class="btn btn-xs btn-danger btn-shadow">
                                    <span class="fa fa-ban"></span>

                                </button>
                            @endif
                        </td>
                        <td>
                        <a href="{{ route("admin.newAdFromMabino.delete",$item->id) }}"
                               class="btn btn-warning btn-xs btn-shadow">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </section>
    </div>
</div>