@extends('layouts.admin.admin')

@section('content')
    <div class=" text-center">
        <span class="text-center btn btn-success"> مبلغ کل دریافتی:{{ number_format($incom) }} تومان </span>
    </div>

    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading">
                <button class="btn btn-default">سودهای دریافت شده حاصل از آگهی</button>
            </header>

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i>شناسه</th>
                    <th><i class="icon-question-sign"></i>مبلغ</th>
                    <th><i class="icon-user"></i>عنوان کمپین</th>
                    <th><i class="icon-mobile-phone"></i>آگهی دهنده</th>
                    <th><i class="icon-bookmark"></i>پیج مربوطه</th>
                    <th><i class=" icon-edit"></i>تاریخ </th>
                </tr>
                </thead>
                <tbody>
                @foreach($profits as $profit)

                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td>{{ persianFormat(number_format($profit->amount)) }}</td>
                        <td>{{ $profit->ad->campain->title}}</td>
                        <td>{{ $profit->ad->campain->user->name }}</td>
                        <td>@if(!is_null($profit->page)) {{ $profit->page->user->name }}-{{ $profit->page->instapage_id }} @else پیج حذف شده است @endif</td>

                        <td>
                            @php
                                $jdf =new \App\Jdf();
                            @endphp
                            {{  getjalaliDate($profit->created_at) }}
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
            {{ $profits->render() }}

        </section>
    </div>




@endsection

