@extends('layouts.auth')

@section('content')
    <div>{{ auth()->user() }}</div>

    @guest
        <form action="{{ route('login') }}" method="GET">
            <x-forms.primary-button>Login</x-forms.primary-button>
        </form>
    @endguest

    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @method('DELETE');
            <x-forms.primary-button>Logout</x-forms.primary-button>
        </form>
    @endauth
@endsection
