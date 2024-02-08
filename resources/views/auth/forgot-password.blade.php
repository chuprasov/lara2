@extends('layouts.auth')

@section('title', 'Забыл пароль')

@section('content')
    <x-forms.auth-forms title="Забыл пароль" action="{{ route('sendResetLink') }}" method="POST">
        @csrf

        <x-forms.text-input type="email" name="email" placeholder="E-mail" required :isError="$errors->has('email')" />

        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>Восстановить пароль</x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}"
                        class="text-black hover:text-darkblue font-bold">Вход в аккаунт</a></div>
            </div>
        </x-slot:buttons>

    </x-forms.auth-forms>
@endsection
