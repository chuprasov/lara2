@if ($message = Session::get('success'))
    <div class="bg-cyan-600 text-white px-4 py-3 shadow-md" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="bg-cyan-600 text-white px-4 py-3 relative" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="bg-cyan-600 text-white p-4" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="bg-cyan-600 text-white px-4 py-3" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="bg-cyan-600 text-white px-4 py-3 relative" role="alert">
        <span class="block sm:inline">{{ $errors->first() }}</span>
    </div>
@endif
