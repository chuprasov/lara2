@extends('layouts.app')

@section('title', 'Корзина')

@section('content')

    <main class="pb-16 lg:py-8 min-h-screen">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4">
                <li><a href="{{ route('home') }}" class="text-gray hover:text-darkblue text-xs">Главная</a></li>
                <li><span class="text-gray text-xs">Корзина покупок</span></li>
            </ul>

            <section class="mb-24">
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black text-darkblue">Корзина покупок</h1>

                @if ($cartItems->isEmpty())
                    <div class="py-3 px-6 rounded-lg bg-darkblue text-white">В корзине пусто</div>
                @else
                    <!-- Adaptive table -->
                    <div class="lg:overflow-auto">
                        <table class="mx-[-50px] lg:mx-0 min-w-full border-spacing-y-4 text-white text-sm text-left"
                            style="border-collapse: separate">

                            <thead class="hidden lg:table-header-group lg:text-xs uppercase text-darkblue">
                                <th scope="col" class="py-3 px-6">Товар</th>
                                <th scope="col" class="py-3 px-6">Цена</th>
                                <th scope="col" class="py-3 px-6">Количество</th>
                                <th scope="col" class="py-3 px-6">Сумма</th>
                                <th scope="col" class="py-3 px-6"></th>
                            </thead>

                            <tbody>

                                @foreach ($cartItems as $cartItem)
                                    <tr class="mb-4 lg:mb-0 grid grid-cols-2 lg:table-row">
                                        <td scope="row" class="col-span-2 py-4 px-4 md:px-6 rounded-t-lg lg:rounded-tr-none lg:rounded-l-lg bg-gray">
                                            <div class="items-start flex lg:flex-row min-w-[200px] gap-2 lg:gap-6 lg:items-center">
                                                <div
                                                    class="shrink-0 overflow-hidden w-[150px] lg:w-[84px] h-[150px] lg:h-[84px] rounded-lg">
                                                    <img src="{{ $cartItem->product->makeThumbnail('original') }}"
                                                        class="object-cover w-full h-full"
                                                        alt="{{ $cartItem->product->title }}">
                                                </div>
                                                <div class="py-3">
                                                    <h4 class="text-xs sm:text-sm xl:text-md font-bold">
                                                        <a href="{{ route('product', $cartItem->product) }}"
                                                            class="inline-block text-white hover:text-darkblue">
                                                            {{ $cartItem->product->title }}
                                                        </a>
                                                    </h4>

                                                    @if ($cartItem->optionValues->isNotEmpty())
                                                        <ul class="space-y-1 mt-2 text-xs">
                                                            @foreach ($cartItem->optionValues as $optionValue)
                                                                <li class="text-body">
                                                                    {{ $optionValue->option->title . ': ' . $optionValue->title }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 md:px-6 bg-gray">
                                            <div class="justify-center flex lg:block text-lg lg:text-sm mt-2 lg:mt-0 font-medium whitespace-nowrap">
                                                {{ $cartItem->product->priceFormatted() }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 md:px-6 bg-gray">
                                            <div class="flex items-stretch h-[56px] gap-2">
                                                <form action="{{ route('cart.quantity', $cartItem) }}" method="POST" id="cart-form">
                                                    @csrf
                                                    <button type="button" id="minus"
                                                        class="minus w-10 lg:w-12 h-10 lg:h-full rounded-lg border border-black/20 hover:bg-bgheader/80 active:bg-card/50  bg-bgheader text-black text-xs text-center font-bold shadow-transparent outline-0 transition">-</button>
                                                    <input name="quantity" type="number" id="quantity"
                                                        class="quantity h-10 lg:h-full px-2 lg:px-4 rounded-lg border  border-black/20 bg-bgheader text-black text-xs text-center font-bold shadow-transparent outline-0 transition placeholder:text-black"
                                                        min="1" max="999" value="{{ $cartItem->quantity }}"
                                                        placeholder="К-во">
                                                    <button type="button" id="plus"
                                                        class="plus w-10 lg:w-12 h-10 lg:h-full rounded-lg border border-black/20 hover:bg-bgheader/80 active:bg-card/50  bg-bgheader text-black text-xs text-center font-bold shadow-transparent outline-0 transition">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="rounded-bl-lg lg:rounded-none py-4 px-4 md:px-6 bg-gray">
                                            <div class="text-xl ml-2 mt-[-14px] lg:mt-0 lg:ml-0 lg:text-sm font-medium whitespace-nowrap">
                                                {{ $cartItem->amount }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 md:px-6 rounded-br-lg lg:rounded-r-lg bg-gray">
                                            <form action="{{ route('cart.delete', $cartItem->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-12 !h-12 !px-0 mt-[-14px] lg:mt-0 btn btn-blue ml-28 lg:ml-0"
                                                    title="Удалить из корзины">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 52 52">
                                                        <path
                                                            d="M49.327 7.857H2.673a2.592 2.592 0 0 0 0 5.184h5.184v31.102a7.778 7.778 0 0 0 7.776 7.776h20.735a7.778 7.778 0 0 0 7.775-7.776V13.041h5.184a2.592 2.592 0 0 0 0-5.184Zm-25.919 28.51a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96Zm10.368 0a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96ZM20.817 5.265h10.367a2.592 2.592 0 0 0 0-5.184H20.817a2.592 2.592 0 1 0 0 5.184Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-8">
                        <div class="text-[32px] font-black text-darkblue">
                            Итого: {{ cart()->total() }}
                        </div>
                        <div class="pb-3 lg:pb-0">
                            <form action="{{ route('cart.truncate') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-black hover:text-darkblue font-medium">
                                    Очистить корзину
                                </button>
                            </form>
                        </div>
                        <div class="flex flex-col sm:flex-row lg:justify-end gap-4">
                            <a href="{{ route('catalog') }}" class="btn btn-gray">За покупками</a>
                            <a href="{{ route('order') }}" class="btn btn-blue">Оформить заказ</a>
                        </div>
                    </div>

                @endif

            </section>

        </div>
    </main>

@endsection
