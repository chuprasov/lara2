<a href="{{ route('catalog', $categoryEach) }}"
    class=" {{ $categoryEach->id === $category->id ? 'text-purple' : 'text-white' }} text-xxs sm:text-xs lg:text-sm text-white font-semibold hover:text-purple">
    {{ $categoryEach->title }}
</a>
