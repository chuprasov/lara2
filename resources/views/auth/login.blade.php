@extends('layouts.auth')

@section('title', 'Вход в аккаунт')

@section('content')
    <x-forms.auth-forms title="Вход в аккаунт" action="{{ route('authenticate') }}" method="POST">
        @csrf

        <x-forms.text-input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required
            :isError="$errors->has('email')" />

        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input type="password" name="password" placeholder="Пароль" required :isError="$errors->has('password')" />

        <x-forms.primary-button>Войти</x-forms.primary-button>

        <x-slot:socialAuth>
            <x-forms.social />
        </x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('forgotPassword') }}"
                        class="text-white hover:text-white/70 font-bold">Забыли пароль?</a></div>
                <div class="text-xxs md:text-xs"><a href="{{ route('register') }}"
                        class="text-white hover:text-white/70 font-bold">Регистрация</a></div>
            </div>
        </x-slot:buttons>

    </x-forms.auth-forms>
@endsection
