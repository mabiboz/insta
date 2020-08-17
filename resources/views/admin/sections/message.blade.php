@if(!is_null((session('flash_message')) && !is_null((session('flash_message')))))
    <p class="alert alert-{{ session('flash_message_type') }}">
        {{ session('flash_message') }}
    </p>
@endif