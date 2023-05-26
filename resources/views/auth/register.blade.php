<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="username" :value="__('Username')" />

                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />

                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- TeamName -->
            <div class="mt-4">
                <x-input-label for="club_name" :value="__('Club Name')" />

                <x-text-input id="clubName" class="block mt-1 w-full" type="text" name="club_name" :value="old('club_name')" required autofocus />

                <x-input-error :messages="$errors->get('club_name')" class="mt-2" />
            </div>

            <!-- Country for team -->

            <div class="mt-4">
                <x-input-label for="country" :value="__('Country')" />

                <x-select-country name="country" :options="\App\Models\Country::get()" :value="old('country')" required autofocus/>

                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>

  



            {{-- <label for="Country"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Country</label>
                        <div class="col-sm-10">
                            <select name="country_id" id="new"
                                class="form-control dynamic" data-dependent ='town_name'>
                                <option value="" disabled selected>
                                   Select Country </option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        <label for="Town"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Town</label>
                            <div class="col-sm-10">
                                <select name="town_id" id="newa"
                                    class="form-control">
                                    <option value="" disabled selected>
                                        Select Town </option>              
                                        @foreach (App\Http\Controllers\ClubController::getTowns($club->country->id) as $town)
                                        
                                        <option value="{{ $town->id }}"> 
                                            {{ $town->town_name }}</option>
                                            @endforeach
                                            @if ( ($club->town->id ?? null) !==null )
                                            <option value=""> 
                                                -</option>
                                        @endif
                                        </select>
                                    </div>

 --}}


            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
