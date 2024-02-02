<div class="pb-8">
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>

    <div class="flex items-center justify-between gap-3 mb-2">
        <span class="text-gray text-xxs font-medium">От, ₽</span>
        <span class="text-gray text-xxs font-medium">До, ₽</span>
    </div>

    <div class="flex items-center gap-3">
        <input
            id="{{ $filter->id('from') }}"
            name="{{ $filter->name('from') }}"
            value="{{ $filter->requestValue('from', 0) }}"
            type="number"
            class="w-full h-12 px-4 rounded-lg border border-black bg-gray/5 text-dark text-xs shadow-transparent outline-0 transition"
            value="9800" placeholder="От"
        >
        <span class="text-body text-sm font-medium">–</span>
        <input
            id="{{ $filter->id('to') }}"
            name="{{ $filter->name('to') }}"
            type="number"
            value="{{ $filter->requestValue('to', 100000) }}"
            class="w-full h-12 px-4 rounded-lg border border-black bg-gray/5 text-dark text-xs shadow-transparent outline-0 transition"
            value="142800" placeholder="До"
        >
    </div>
</div>
