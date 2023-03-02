<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 boxx">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div style="display:flex; justify-content: space-between;">
                        <div>Welcome back, {{ Auth::user()->username }} </div>
                        <div style="float:right">Your account role is {{ Auth::user()->role }} </div>
                        <br>
                    </div>
                    <div class="loginBlock">
                        @if (Auth::user()->logins !== null)
                            <div>Last login was: {{ str_replace('~', ' from ', array_values(Auth::user()->logins)[1]) }}
                            </div>
                        @else
                            <div> first login </div>
                        @endif
                    </div>
                        @if (!Auth::user())
                            <button>
                                <a href="{{ route('login') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                            </button>
                        @endif             
                </div>
            </div>
            @if (Auth::user()->role === 'admin')
                        <div class='adminPanel'>
                            <h5>Admin panel </h5>
                            <button class="button">
                                <a href="{{ route('users') }}">Users</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('national') }}">Countries</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('towns') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Towns</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('clubs') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Clubs</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('players') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Players</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('nameSurname') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Names and Surnames
                                    pools</a>
                            </button>
                            <button class="button">
                                <a href="{{ route('generator') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Generate players</a>
                            </button>
                        </div>
                    @endif
        </div>
    </div>
</x-app-layout>
