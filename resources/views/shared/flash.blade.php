@if (session()->has('message'))
    <div class="{{ $message->class() }} p-5">
        {{ session('message') }}
    </div>
@endif
