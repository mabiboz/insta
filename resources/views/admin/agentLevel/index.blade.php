@extends("layouts.admin.admin")

@section("content")
    <div class="row" style="zoom: 80%">

        <div class="col-xs-12 col-md-4">
            @include("admin.agentLevel.sections.form")
        </div>

        <div class="col-xs-12 col-md-8 ">
            <section class="panel">
                <header class="panel-heading">
                    لیست سطوح نمایندگی

                </header>
                <table class="table  table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>قیمت(تومان)</th>
                        <th>درصد مابینو</th>
                        <th>درصد نمایندگی</th>
                        <th>درصد ادمین</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agentLevels as $level)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $level->title }}</td>
                            <td>{{ number_format($level->price) }}</td>
                            <td>{{ $level->mabino_percent }}</td>
                            <td>{{ $level->my_percent }}</td>
                            <td>{{ $level->pageowner_percent }}</td>
                            <td>
                                @if($level->status == \App\Models\AgentLevel::ACTIVE)
                                    <span class="icon-unlock" style="font-size: 18px;color: green"></span>
                                @else
                                    <span class="icon-lock" style="font-size: 18px;color: red;"></span>

                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.agentLevel.edit',$level) }}"
                                   title="ویرایش "
                                   class="btn btn-primary btn-xs"><i
                                            class="icon-pencil"></i></a>
                                <a href="{{ route('admin.agentLevel.changeStatus',$level) }}"
                                   title="تغییر وضعیت"
                                   class="btn btn-success btn-xs">
                                    <i class="icon-key"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection
