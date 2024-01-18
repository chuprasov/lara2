@extends('layouts.app')

{{-- @section('title', $category->title ?? 'Каталог') --}}

@section('content')
    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href={{ route('home') }} class="text-body hover:text-pink text-xs">Главная</a></li>
        <li><a href={{ route('catalog') }} class="text-body hover:text-pink text-xs">Каталог</a></li>

        @if ($category->exists)
            <li>
                <span class="text-body text-xs">
                    {{ $category->title }}
                </span>
            </li>
        @endif
    </ul>

    <section class="mt-16 lg:mt-10">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[32px] font-black">Категории</h2>

        <a href="{{ route('catalog') }}">Все категории</a>

        <!-- Categories -->
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4 md:gap-5 mt-8">
            {{-- @each('catalog.shared.category', $categories, 'categoryEach') --}}
            @foreach ($categories as $categoryEach)
                @include('catalog.shared.category', ['categoryEach' => $categoryEach])
            @endforeach
        </div>
    </section>

    <section class="mt-16 lg:mt-10">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[32px] font-black">Каталог товаров</h2>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-6 2xl:gap-8 mt-8">

            <!-- Filters -->
            <aside class="basis-2/5 xl:basis-1/4">
                <form action="{{ route('catalog', $category) }}"
                    class="overflow-auto max-h-[320px] lg:max-h-[100%] space-y-10 p-6 2xl:p-8 rounded-2xl bg-card">

                    <input type="hidden" name="sort" value="{{ request('sort') }}">

                    <!-- Filter items -->
                    @foreach (filters() as $filter)
                        {!! $filter !!}
                    @endforeach

                    <div>
                        <button type="submit" class="w-full !h-16 btn btn-pink">Применить</button>
                    </div>

                    @if (request('filters'))
                        <div>
                            <a href={{ route('catalog', $category) }} type="reset"
                                class="w-full !h-16 btn btn-outline">Сбросить фильтры</a>
                        </div>
                    @endif
                </form>
            </aside>

            <div class="basis-auto xl:basis-3/4">
                <!-- Sort by -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">

                            <a href="{{ route('catalog', ['view-products' => 'grid']) }}"
                                class="{{ session()->get('view-products') === 'grid' ? 'pointer-events-none text-pink' : ''}} inline-flex items-center justify-center w-10 h-10 rounded-md bg-card ">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 52 52">
                                    <path fill-rule="evenodd"
                                        d="M2.6 28.6h18.2a2.6 2.6 0 0 1 2.6 2.6v18.2a2.6 2.6 0 0 1-2.6 2.6H2.6A2.6 2.6 0 0 1 0 49.4V31.2a2.6 2.6 0 0 1 2.6-2.6Zm15.6 18.2v-13h-13v13h13ZM31.2 0h18.2A2.6 2.6 0 0 1 52 2.6v18.2a2.6 2.6 0 0 1-2.6 2.6H31.2a2.6 2.6 0 0 1-2.6-2.6V2.6A2.6 2.6 0 0 1 31.2 0Zm15.6 18.2v-13h-13v13h13ZM31.2 28.6h18.2a2.6 2.6 0 0 1 2.6 2.6v18.2a2.6 2.6 0 0 1-2.6 2.6H31.2a2.6 2.6 0 0 1-2.6-2.6V31.2a2.6 2.6 0 0 1 2.6-2.6Zm15.6 18.2v-13h-13v13h13ZM2.6 0h18.2a2.6 2.6 0 0 1 2.6 2.6v18.2a2.6 2.6 0 0 1-2.6 2.6H2.6A2.6 2.6 0 0 1 0 20.8V2.6A2.6 2.6 0 0 1 2.6 0Zm15.6 18.2v-13h-13v13h13Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>

                            <a href="{{ route('catalog', ['view-products' => 'list']) }}"
                                class="{{ session()->get('view-products') === 'list' ? 'pointer-events-none text-pink' : ''}} inline-flex items-center justify-center w-10 h-10 rounded-md bg-card hover:text-pink">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 52 52">
                                    <path fill-rule="evenodd"
                                        d="M7.224 4.875v4.694h37.555V4.875H7.224ZM4.877.181a2.347 2.347 0 0 0-2.348 2.347v9.389a2.347 2.347 0 0 0 2.348 2.347h42.25a2.347 2.347 0 0 0 2.347-2.347v-9.39A2.347 2.347 0 0 0 47.127.182H4.877Zm2.347 23.472v4.694h37.555v-4.694H7.224Zm-2.347-4.695a2.347 2.347 0 0 0-2.348 2.348v9.389a2.347 2.347 0 0 0 2.348 2.347h42.25a2.347 2.347 0 0 0 2.347-2.348v-9.388a2.347 2.347 0 0 0-2.347-2.348H4.877ZM7.224 42.43v4.695h37.555v-4.694H7.224Zm-2.347-4.694a2.347 2.347 0 0 0-2.348 2.347v9.39a2.347 2.347 0 0 0 2.348 2.346h42.25a2.347 2.347 0 0 0 2.347-2.347v-9.389a2.347 2.347 0 0 0-2.347-2.347H4.877Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            
                        </div>
                        <div class="text-body text-xxs sm:text-xs">Найдено: {{ $products->total() }} товаров</div>
                    </div>
                    <div x-data="{}" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <span class="text-body text-xxs sm:text-xs">Сортировать по</span>
                        <form x-ref="sortForm" action="{{ route('catalog', $category) }}">
                            <select name="sort" x-on:change="$refs.sortForm.submit()"
                                class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xxs sm:text-xs shadow-transparent outline-0 transition">
                                <option value="" class="text-dark">
                                    умолчанию
                                </option>
                                <option @selected(request('sort') === 'price') value="price" class="text-dark">
                                    возрастанию цены
                                </option>
                                <option @selected(request('sort') === '-price') value="-price" class="text-dark">
                                    убыванию цены
                                </option>
                                <option @selected(request('sort') === 'title') value="title" class="text-dark">
                                    наименованию
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products list -->
                @if (session()->get('view-products') === 'grid')
                    <div
                        class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-x-8 gap-y-8 lg:gap-y-10 2xl:gap-y-12 mt-8">
                        @each('catalog.shared.product', $products, 'product')
                    </div>
                @else
                    <div class="products grid grid-cols-1 gap-y-8">
                        @each('catalog.shared.product-list', $products, 'product')
                    </div>
                @endif

                <!-- Page pagination -->
                <div class="mt-12">
                    {{ $products->withQueryString()->onEachSide(3)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

    </section>
@endsection