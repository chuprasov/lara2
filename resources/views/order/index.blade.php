@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')

    <main class="py-8">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-gray hover:text-darkblue text-xs">Главная</a></li>
                <li><a href="{{ route('cart') }}" class="text-gray hover:text-darkblue text-xs">Корзина покупок</a></li>
                <li><span class="text-gray text-xs">Оформление заказа</span></li>
            </ul>

            <section>
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black text-darkblue">Оформление заказа</h1>

                <form action="{{ route('order.handle') }}" method="POST">
                    
                    @csrf
                    
                    <div class="grid xl:grid-cols-3 items-start gap-4 mt-8 mb-6">

                        <!-- Contact information -->
                        <div class="p-6 2xl:p-8 rounded-lg bg-gray/5 border border-black">
                            <h3 class="mb-6 text-md 2xl:text-lg font-bold text-dark">Контактная информация</h3>
                            <div class="space-y-2">

                                <x-forms.text-input type="text" name="customer[first_name]" placeholder="Имя"
                                    value="{{ old('customer.first_name') }}" :isError="$errors->has('customer.first_name')" />

                                @error('customer.first_name')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror

                                <x-forms.text-input type="text" name="customer[last_name]" placeholder="Фамилия"
                                    value="{{ old('customer.last_name') }}" :isError="$errors->has('customer.last_name')" />

                                @error('customer.last_name')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror

                                <x-forms.text-input type="text" name="customer[phone]" placeholder="Номер телефона"
                                    value="{{ old('customer.phone') }}" :isError="$errors->has('customer.phone')" />

                                @error('customer.phone')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror

                                <x-forms.text-input type="email" name="customer[email]" placeholder="E-mail"
                                    value="{{ old('customer.email') }}" :isError="$errors->has('customer.email')" />

                                @error('customer.email')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror


                                

                            </div>
                        </div>

                            

                            <!-- Payment-->
                            <div>
                                <div class="p-6 2xl:p-8 rounded-lg bg-gray/5 border border-black mb-8">
                                    <h3 class="mb-6 text-md 2xl:text-lg font-bold text-black">Метод оплаты</h3>
                                    <div class="space-y-5">
                                        @foreach ($payments as $payment)
                                            <div class="form-radio">
                                                <input type="radio" name="payment_method_id"
                                                    id="payment-method-{{ $payment->id }}" value="{{ $payment->id }}"
                                                    @checked($loop->first || old('payment_method_id') === $payment->id)>
                                                <label for="payment-method-{{ $payment->id }}" class="form-radio-label">
                                                    {{ $payment->title }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @guest
                                    <div class="p-6 2xl:p-8 rounded-lg bg-gray/5 border border-black" x-data="{ createAccount: false }">
                                        <div class="py-3 text-darkblue">Вы можете создать аккаунт после оформления заказа</div>
                                        <div class="form-checkbox">
                                            <input name="create_account" type="checkbox" id="checkout-create-account" value="1"
                                                @checked(old('create_account'))>
                                            <label for="checkout-create-account" class="form-checkbox-label"
                                                @click="createAccount = ! createAccount">Зарегистрировать аккаунт</label>
                                        </div>
                                        <div x-show="createAccount" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0" class="mt-4 space-y-3">

                                            <x-forms.text-input type="password" name="password" placeholder="Придумайте пароль"
                                                :isError="$errors->has('password')" />

                                            @error('password')
                                                <x-forms.error>
                                                    {{ $message }}
                                                </x-forms.error>
                                            @enderror

                                            <x-forms.text-input type="password" name="password_confirmation"
                                                placeholder="Повторите пароль" :isError="$errors->has('password_confirmation')" />

                                            @error('password_confirmation')
                                                <x-forms.error>
                                                    {{ $message }}
                                                </x-forms.error>
                                            @enderror
                                        </div>
                                    </div>
                                    @endguest
                                </div>
                                <!-- Shipping-->
                            <div class="p-6 2xl:p-8 rounded-lg bg-gray/5 border border-black">
                                <h3 class="mb-6 text-md 2xl:text-lg font-bold text-black">Способ доставки</h3>
                                <div class="space-y-5">

                                    @foreach ($deliveries as $delivery)
                                        <div class="space-y-8">

                                            <div class="form-radio">
                                                <input type="radio" name="delivery_type_id"
                                                    id="delivery-type-{{ $delivery->id }}" value="{{ $delivery->id }}"
                                                    @checked($loop->first || old('delivery_id') === $delivery->id)>
                                                <label for="delivery-type-{{ $delivery->id }}" class="form-radio-label">
                                                    {{ $delivery->title }}
                                                </label>
                                            </div>

                                            @if ($delivery->with_address)
                                                <x-forms.text-input type="text" name="customer[city]" placeholder="Город"
                                                    value="{{ old('customer.city') }}" :isError="$errors->has('customer.city')" />

                                                @error('customer.city')
                                                    <x-forms.error>
                                                        {{ $message }}
                                                    </x-forms.error>
                                                @enderror

                                                <x-forms.text-input type="text" name="customer[address]" placeholder="Адрес"
                                                    value="{{ old('customer.address') }}" :isError="$errors->has('customer.address')" />

                                                @error('customer.address')
                                                    <x-forms.error>
                                                        {{ $message }}
                                                    </x-forms.error>
                                                @enderror
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                            


                    <!-- Checkout -->
                    <div class="p-6 2xl:p-8 rounded-lg bg-gray/5 border border-black">
                        <h3 class="mb-6 text-md 2xl:text-lg font-bold text-black">Заказ</h3>
                        <table class="w-full border-spacing-y-3 text-dark text-xxs text-left"
                            style="border-collapse: separate">
                            <thead class="text-[12px] text-dark uppercase">
                                <th scope="col" class="pb-2 border-b border-black">Товар</th>
                                <th scope="col" class="px-2 pb-2 border-b border-black">К-во</th>
                                <th scope="col" class="px-2 pb-2 border-b border-black">Сумма</th>
                            </thead>
                            <tbody>

                                @foreach ($items as $item)
                                    <tr>
                                        <td scope="row" class="pb-3 border-b border-black">
                                            <h4 class="font-bold">
                                                <a href="{{ route('product', $item->product) }}"
                                                    class="inline-block text-dark hover:text-darkblue break-words pr-3">
                                                    {{ $item->product->title }}
                                                </a>
                                            </h4>

                                            @if ($item->optionValues->isNotEmpty())
                                                <ul>
                                                    @foreach ($item->optionValues as $optionValue)
                                                        <li class="text-black">
                                                            {{ $optionValue->option->title . ': ' . $optionValue->title }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="px-2 pb-3 border-b border-black whitespace-nowrap">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-2 pb-3 border-b border-black whitespace-nowrap">
                                            {{ $item->amount }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-xs font-semibold text-right text-black content-between w-full">
                            Всего: {{ cart()->total() }}
                        </div>

                        <div class="mt-8 space-y-8">
                            <!-- Promocode -->
                            {{-- <div class="space-y-4">
                                <div class="flex gap-3">
                                    <input type="text"
                                        class="grow w-full h-[56px] px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                        placeholder="Промокод" required>
                                    <button type="submit" class="shrink-0 w-14 !h-[56px] !px-0 btn btn-purple">→</button>
                                </div>
                                <div class="space-y-3">
                                    <div class="px-4 py-3 rounded-lg bg-[#137d3d] text-xs">Промокод <a href="#"
                                            class="mx-2 py-0.5 px-1.5 rounded-md border-dashed border-2 text-white hover:text-white/70 text-xs"
                                            title="Удалить промокод">&times; leeto15</a> успешно добавлен.</div>
                                    <div class="px-4 py-3 rounded-lg bg-[#b91414] text-xs">Промокод <b>leeto15</b> удалён.</div>
                                    <div class="px-4 py-3 rounded-lg bg-[#b91414] text-xs">Промокод <b>leeto15</b> не найден.</div>
                                </div>
                            </div> --}}

                            <!-- Summary -->
                            <table class="text-right w-full">
                                <tbody>
                                    {{-- <tr>
                                        <th scope="row" class="pb-2 text-xs font-medium">Доставка:</th>
                                        <td class="pb-2 text-xs">
                                            {{}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="pb-2 text-xs font-medium">Промокод:</th>
                                        <td class="pb-2 text-xs">15 398 ₽</td>
                                    </tr> --}}
                                    <tr>
                                        <th scope="row" class="text-lg font-black text-black">Итого:</th>
                                        <td class="text-lg font-black text-black w-[300px]">
                                            {{ cart()->total() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Process to checkout -->
                            <button type="submit" class="w-full btn btn-blue">Оформить заказ</button>
                        </div>
                    </div>

                </form>
            </section>

        </div>
    </main>

@endsection
