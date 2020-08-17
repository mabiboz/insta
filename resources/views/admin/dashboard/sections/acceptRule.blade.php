<p>
 این قوانین ما می باشد !
</p>

<form action="{{ route('user.acceptRules') }}" method="post">
    {{ csrf_field() }}
    <label for="accept">می پذیرم</label>
    <input type="checkbox" name="accept" id="accept">
    <button id="btnAccept" class="btn btn-success btn-lg " style="display: none;">
       تایید نهایی
    </button>
</form>