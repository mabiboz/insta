<table class="table table-hover">

    @foreach($pages as $page)

        <tr>
            <td>{{ $page->name }}</td>
            <td>{{ $page->instapage_id }}</td>
            <td>

                @if($page->pageRequestStatus == \App\Models\PageRequest::ACCEPTED )
                    <span class="btn btn-success btn-xs">تایید شده</span>
                @elseif($page->pageRequestStatus == \App\Models\PageRequest::PENDING)
                    <span class="btn btn-warning btn-xs">در انتظار تایید</span>
                @elseif($page->pageRequestStatus == \App\Models\PageRequest::FINISHED)
                    <span class="btn btn-primary btn-xs">تکمیل شده</span>
                @else
                    <span class="btn btn-danger btn-xs">رد شده</span>
                @endif
            </td>

            @if($page->pageRequestStatus == \App\Models\PageRequest::FINISHED || $page->pageRequestStatus == \App\Models\PageRequest::ACCEPTED)
                <td> لایک: <br>{{ $page->like }}</td>
                <td> کامنت: <br>{{ $page->comment}}</td>
                <td> بازدید:<br>{{ $page->view }}</td>
                <td> فالور:<br>{{ $page->followers}}</td>
                <td> قیمت پایه:<br>{{number_format( $page->price)}}</td>
                <td> قیمت پرداختی:<br>
                @if($ad->is_mabinoe)
                {{number_format( $page->price*getRatio($ad->day_count)/2)}}
                @else
                {{number_format( $page->price*getRatio($ad->day_count))}}
                @endif
                
                </td>
                <td> وضعیت تاکنون :
                    <br>
                    @if(is_null($page->endshow))
                        <button class="btn btn-success btn-xs">فعال در صفحه</button>
                    @else
                    @if($page->end_work == 0)
                        <span class="badge">حذف شده در
                        {{ Morilog\Jalali\Jalalian::forge($page->endshow)->format("d-m-Y i:H") }}
                        </span>
                        @else
                          <span class="badge">پایان یافته در
                        {{ Morilog\Jalali\Jalalian::forge($page->endshow)->format("d-m-Y i:H") }}
                        </span>
                        
                    @endif
                     @endif
                </td>

            @endif


        </tr>


    @endforeach

</table>