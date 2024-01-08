@if ($message = Session::get('success'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <span class="block sm:inline">{{ $error }}</span>
    </div>
@endif
