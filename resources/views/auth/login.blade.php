<x-layouts.guest>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="flex-1 bg-indigo-100 hidden lg:flex">
            <div class="w-full background-walk-y relative overlay-gradient-bottom"
                style="background-image: url('https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                <div class="absolute bottom-0 left-0 z-10">
                    <div class="p-5 mb-2 text-white">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 font-bold text-6xl">Good Morning</h1>
                            <h5 class="font-normal text-xl text-white">Klingking Beach, Nusapenida, Bali, Indonesia</h5>
                        </div>
                        <div class="text-sm">
                            Photo by <a class="no-underline border-b-[1px] border-indigo-500 pb-1" target="_blank"
                                href="https://unsplash.com/photos/aerial-photography-of-cliff-near-shore-Bi_5VsaOLnI">Alec
                                Favale</a> on <a class="no-underline border-b-[1px] border-indigo-500 pb-1"
                                target="_blank" href="https://unsplash.com">Unsplash</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="flex flex-col mx-auto w-32 items-center">
                <div class="text-4xl text-indigo-800 uppercase font-extrabold">
                    {{ config('app.name') }}
                </div>
            </div>
            <div class="mt-8 flex flex-col items-center">
                <h1 class="text-xl xl:text-2xl font-bold">
                    Sign In
                </h1>
                <div class="w-full flex-1 mt-8">
                    <div class="mx-auto max-w-xs">
                        <x-validation-errors class="mb-4" />

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="current-password" />
                            </div>

                            <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-checkbox id="remember_me" name="remember" />
                                    <span
                                        class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <x-button class="ms-4">
                                    {{ __('Log in') }}
                                </x-button>
                            </div>
                        </form>
                        {{-- <input
                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                        type="email" placeholder="Email" />
                    <input
                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                        type="password" placeholder="Password" />
                    <button
                        class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                        <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <path d="M20 8v6M23 11h-6" />
                        </svg>
                        <span class="ml-3">
                            Sign In
                        </span>
                    </button> --}}
                        {{-- <p class="mt-6 text-xs text-gray-600 text-center">
                        I agree to abide by {{ config('app.name') }}'s
                        <a href="#" class="border-b border-gray-500 border-dotted">
                            Terms of Service
                        </a>
                        and its
                        <a href="#" class="border-b border-gray-500 border-dotted">
                            Privacy Policy
                        </a>
                    </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
