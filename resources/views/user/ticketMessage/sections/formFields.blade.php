{{ csrf_field() }}
<div class="form-group">
    <label for="title">عنوان تیکت</label>


    <input type="text" class="form-control input-lg" id="title" value="{{ isset($ticketMessage) ? $ticketMessage->title : old('title','') }}"
           name="title" placeholder="عنوان تیکت">

</div>



<div class="form-group">
    <label for="content">محتوا تیکت</label>
    <textarea name="content" id="content" cols="30"  class="form-control input-lg" rows="10">{{ isset($ticketMessage) ? $ticketMessage->content : old('content','') }}</textarea>
</div>


