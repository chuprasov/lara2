@extends('layouts.app')

@section('content')
    <section class="mt-16 lg:mt-24">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[42px] font-black">Категории</h2>

        <!-- Categories -->
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4 md:gap-5 mt-8">
            @each('catalog.shared.category', $categories, 'category')
        </div>
    </section>

    <section class="mt-16 lg:mt-24">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[42px] font-black">Каталог товаров</h2>

        <!-- Products list -->
        <div
            class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-x-8 gap-y-8 lg:gap-y-10 2xl:gap-y-12 mt-8">
            @each('catalog.shared.product', $products, 'product')
        </div>

        <div class="mt-12 text-center">
            <a href={{ route('catalog') }} class="btn btn-purple">Все товары &nbsp;→</a>
        </div>
    </section>

    <section class="mt-20">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[42px] font-black">Бренды</h2>

        <!-- Brands list -->
        <div class="grid grid-cols-2 md:grid-cols-3 2xl:grid-cols-6 gap-4 md:gap-8 mt-12">
            @each('catalog.shared.brand', $brands, 'brand')
        </div>
    </section>
@endsection
