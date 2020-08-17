<form action="{{ route("admin.planB.Ad.statisticsUpdate") }}" method="post">
    {{ csrf_field() }}

    <input type="hidden" name="statistic" value="{{$statistic->id}}" >
    <div class="form-group">
        <label for="likecount">تعداد لایک </label>
        <input type="text" name="likecount" id="likecount" class="form-control" value="{{ $statistic->likecount }}">
    </div>

    <div class="form-group">
        <label for="commentcount">تعداد کامنت </label>
        <input type="text" name="commentcount" id="commentcount" class="form-control" value="{{ $statistic->commentcount }}">
    </div>

    <div class="form-group">
        <label for="viewcount">تعداد بازدید </label>
        <input type="text" name="viewcount" id="viewcount"  class="form-control" value="{{ $statistic->viewcount }}">
    </div>

    <div class="form-group">
        <label for="followers">تعداد دنبال کننده </label>
        <input type="text" name="followers" id="followers" class="form-control" value="{{ $statistic->followers }}">
    </div>

    <div class="form-group">
        <label for="link">لینک آگهی </label>
        <input type="text" name="link" id="link" class="form-control" value="{{ $pageRequest->link }}">
    </div>

    <button type="submit" class="btn btn-success">بروزرسانی آمار</button>
</form>