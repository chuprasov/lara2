@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <x-forms.auth-forms title="Восстановление пароля" action="" method="POST">
        @csrf

        <x-forms.text-input type="email" name="email" placeholder="E-mail" required :isError="$errors->has('email')" />

        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input type="password" name="password" placeholder="Пароль" required :isError="$errors->has('password')" />

        @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input type="password" name="password_confirmation" placeholder="Повторите пароль" required
            :isError="$errors->has('password')" />

        @error('password_confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>Обновить пароль</x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:buttons></x-slot:buttons>

    </x-forms.auth-forms>
@endsection
