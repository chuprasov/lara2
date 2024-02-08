<a href="catalog.html" class="p-6 rounded-sm bg-gray hover:bg-gray/60">
    <div class="h-12 md:h-16">
        <img src="{{ $brand->makeThumbnail('original') }}" class="object-contain w-full h-full" alt="{{ $brand->title }}">
    </div>
    <div class="mt-4 text-xs sm:text-sm lg:text-md font-semibold text-center">
        {{ $brand->title }}
    </div>
</a>
