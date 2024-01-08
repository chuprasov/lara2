@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <x-forms.auth-forms title="Регистрация" action="{{ route('store') }}" method="POST">
        @csrf

        <x-forms.text-input type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required />

        <x-forms.text-input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required
            :isError="$errors->has('email')" />

        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input type="password" name="password" placeholder="Пароль" value="{{ old('password') }}" required
            :isError="$errors->has('password')" />

        @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input type="password" name="password_confirmation" placeholder="Повторите пароль"
            value="{{ old('password_confirmation') }}" required :isError="$errors->has('password')" />

        @error('password_confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>Регистрация</x-forms.primary-button>

        <x-slot:socialAuth>
            <x-forms.social />
        </x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}"
                        class="text-white hover:text-white/70 font-bold">Вход в аккаунт</a></div>
            </div>
        </x-slot:buttons>

    </x-forms.auth-forms>
@endsection
