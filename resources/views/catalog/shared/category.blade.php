<a href="{{ route('catalog', $categoryEach) }}"
    {{-- class="p-3 sm:p-4 2xl:p-6 rounded-xl bg-card hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold"> --}}
    class="p-3 sm:p-4 2xl:p-6 rounded-xl {{ $categoryEach->id === $category->id ? 'bg-pink' : 'bg-card' }} hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold">
    {{ $categoryEach->title }}
</a>
