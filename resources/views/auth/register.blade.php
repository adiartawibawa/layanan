<x-layouts.guest>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="flex flex-col mx-auto w-32 items-center">
                <div class="text-4xl text-indigo-800 uppercase font-extrabold">
                    {{ config('app.name') }}
                </div>
            </div>
            <div class="mt-8 flex flex-col items-center">
                <h1 class="text-xl xl:text-2xl font-bold">
                    Sign up
                </h1>
                <div class="w-full flex-1 mt-8">
                    {{-- <div class="flex flex-col items-center">
                    <button
                        class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-indigo-100 text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out focus:outline-none hover:shadow focus:shadow-sm focus:shadow-outline">
                        <div class="bg-white p-2 rounded-full">
                            <svg class="w-4" viewBox="0 0 533.5 544.3">
                                <path
                                    d="M533.5 278.4c0-18.5-1.5-37.1-4.7-55.3H272.1v104.8h147c-6.1 33.8-25.7 63.7-54.4 82.7v68h87.7c51.5-47.4 81.1-117.4 81.1-200.2z"
                                    fill="#4285f4" />
                                <path
                                    d="M272.1 544.3c73.4 0 135.3-24.1 180.4-65.7l-87.7-68c-24.4 16.6-55.9 26-92.6 26-71 0-131.2-47.9-152.8-112.3H28.9v70.1c46.2 91.9 140.3 149.9 243.2 149.9z"
                                    fill="#34a853" />
                                <path
                                    d="M119.3 324.3c-11.4-33.8-11.4-70.4 0-104.2V150H28.9c-38.6 76.9-38.6 167.5 0 244.4l90.4-70.1z"
                                    fill="#fbbc04" />
                                <path
                                    d="M272.1 107.7c38.8-.6 76.3 14 104.4 40.8l77.7-77.7C405 24.6 339.7-.8 272.1 0 169.2 0 75.1 58 28.9 150l90.4 70.1c21.5-64.5 81.8-112.4 152.8-112.4z"
                                    fill="#ea4335" />
                            </svg>
                        </div>
                        <span class="ml-4">
                            Sign Up with Google
                        </span>
                    </button>

                    <button
                        class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-indigo-100 text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out focus:outline-none hover:shadow focus:shadow-sm focus:shadow-outline mt-5">
                        <div class="bg-white p-1 rounded-full">
                            <svg class="w-6" viewBox="0 0 32 32">
                                <path fill-rule="evenodd"
                                    d="M16 4C9.371 4 4 9.371 4 16c0 5.3 3.438 9.8 8.207 11.387.602.11.82-.258.82-.578 0-.286-.011-1.04-.015-2.04-3.34.723-4.043-1.609-4.043-1.609-.547-1.387-1.332-1.758-1.332-1.758-1.09-.742.082-.726.082-.726 1.203.086 1.836 1.234 1.836 1.234 1.07 1.836 2.808 1.305 3.492 1 .11-.777.422-1.305.762-1.605-2.664-.301-5.465-1.332-5.465-5.93 0-1.313.469-2.383 1.234-3.223-.121-.3-.535-1.523.117-3.175 0 0 1.008-.32 3.301 1.23A11.487 11.487 0 0116 9.805c1.02.004 2.047.136 3.004.402 2.293-1.55 3.297-1.23 3.297-1.23.656 1.652.246 2.875.12 3.175.77.84 1.231 1.91 1.231 3.223 0 4.61-2.804 5.621-5.476 5.922.43.367.812 1.101.812 2.219 0 1.605-.011 2.898-.011 3.293 0 .32.214.695.824.578C24.566 25.797 28 21.3 28 16c0-6.629-5.371-12-12-12z" />
                            </svg>
                        </div>
                        <span class="ml-4">
                            Sign Up with GitHub
                        </span>
                    </button>
                </div>

                <div class="my-12 border-b text-center">
                    <div
                        class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-gray-100 transform translate-y-1/2">
                        Or sign up with e-mail
                    </div>
                </div> --}}

                    <div class="mx-auto max-w-xs">
                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div>
                                <x-label for="firstname" value="{{ __('First Name') }}" />
                                <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname"
                                    :value="old('firstname')" required autofocus autocomplete="firstname" />
                            </div>

                            <div class="mt-4">
                                <x-label for="lastname" value="{{ __('Last Name') }}" />
                                <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname"
                                    :value="old('lastname')" required autofocus autocomplete="lastname" />
                            </div>

                            <div class="mt-4">
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                            </div>

                            {{-- @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature()) --}}
                            <div class="mt-4">
                                <x-label for="terms">
                                    <div class="flex items-center">
                                        <x-checkbox name="terms" id="terms" required />

                                        <div class="ms-2">
                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' =>
                                                    '<a target="_blank" href="#" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                                    __('Terms of Service') .
                                                    '</a>',
                                                'privacy_policy' =>
                                                    '<a target="_blank" href="#" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                                    __('Privacy Policy') .
                                                    '</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                            {{-- @endif --}}

                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>

                                <x-button class="ms-4">
                                    {{ __('Register') }}
                                </x-button>
                            </div>
                        </form>
                        {{-- <input
                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                        type="email" placeholder="Email" />
                    <input
                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                        type="password" placeholder="Password" />
                    <input
                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                        type="password" placeholder="Re-Type Password" />
                    <button
                        class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                        <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <path d="M20 8v6M23 11h-6" />
                        </svg>
                        <span class="ml-3">
                            Sign Up
                        </span>
                    </button> --}}
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            I agree to abide by {{ config('app.name') }}'s
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Terms of Service
                            </a>
                            and its
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Privacy Policy
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 hidden lg:flex">
            <div class="w-full background-walk-y relative overlay-gradient-bottom"
                style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1476&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                <div class="absolute bottom-0 left-0 z-10">
                    <div class="p-5 mb-2 text-white">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 font-bold text-6xl">Good Morning</h1>
                            <h5 class="font-normal text-xl text-white">Bali, Indonesia</h5>
                        </div>
                        <div class="text-sm">
                            Photo by <a class="no-underline border-b-[1px] border-indigo-500 pb-1" target="_blank"
                                href="https://unsplash.com/photos/temple-beside-body-of-water-and-trees-1kdIG_258bU">Aron
                                Visuals</a> on <a class="no-underline border-b-[1px] border-indigo-500 pb-1"
                                target="_blank" href="https://unsplash.com">Unsplash</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
