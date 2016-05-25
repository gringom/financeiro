@if (session()->has('flash_message'))
<div class="message-box bg-{{ session('flash_message_level') }}">{{ session('flash_message') }}</div>
@endif