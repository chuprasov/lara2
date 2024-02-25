@extends('layouts.app')

@section('content')
    {{-- <section class="mt-16 lg:mt-24">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[32px] font-black">Категории</h2>
    <section class="">
        <div x-data="{ dropdownCategories: false }" class="categories relative">
            <h2 @click="dropdownCategories = ! dropdownCategories" class="flex items-center cursor-pointer text-darkblue hover:text-blue-600 transition">Категории</h2>
            <div x-show="dropdownCategories" @click.away="dropdownCategories = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute z-50 top-6 left-0 xs:-right-10 sm:-right-40 w-[280px] xl:w-[450px] p-8 rounded-sm shadow-xl bg-card grid xl:grid-cols-2 gap-3 mt-8">
                @foreach ($categories as $categoryEach)
                    @include('catalog.shared.category', ['categoryEach' => $categoryEach])
                @endforeach
            </div>
        </div>
    </section> --}}


    <section class="mt-16 lg:mt-4">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[32px] font-black text-darkblue">Товары</h2>

        <!-- Products list -->
        <div
            class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 mt-8">
            @each('product.shared.product', $products, 'product')
        </div>

        <div class="mt-12 text-center">
            <a href={{ route('catalog') }} class="btn btn-blue">Все товары &nbsp;→</a>
        </div>
    </section>

    <section class="mt-20">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[32px] font-black text-darkblue">Брэнды</h2>

        <!-- Brands list -->
        <div class="grid grid-cols-2 md:grid-cols-3 2xl:grid-cols-6 gap-4 md:gap-8 mt-12">
            @each('catalog.shared.brand', $brands, 'brand')
        </div>
    </section>
@endsection
