@extends("layouts.admin.admin")

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  لیست پیامک ها

                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>دریافت کننده</th>
                        <th>متن</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sms as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td>{{ $item->msg }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
            {{ $sms->links() }}
        </div>
    </div>
@endsection
