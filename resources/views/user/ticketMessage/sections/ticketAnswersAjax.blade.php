<div class="row">
    @foreach($answers as $answer)
        <div class="col-xs-12">
            <p class="alert alert-success">
                {{ $answer->content }}
            </p>

            <p>
                اپراتور :
                {{ $answer->user->name }}
            </p>
            <p>
                تاریخ :
                {{ \Morilog\Jalali\Jalalian::forge($answer->created_at)->format('%A, %d %B %y - H:i') }}
            </p>
        </div>
    @endforeach
</div>