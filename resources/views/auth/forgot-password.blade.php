<x-layouts.guest>
    {{-- <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </div> --}}
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">

            <div class="w-full xl:w-3/4 lg:w-11/12 flex">

                <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
                    style="background-image: url('https://img.freepik.com/free-vector/forgot-password-concept-illustration_114360-1095.jpg?t=st=1722394209~exp=1722397809~hmac=5a8c515194b7cd6c80358fec08b4d32dc498aa4bb76454a66ee264d6c4a23d36&w=740')">
                </div>

                <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
                    <div class="px-8 mb-4 text-center">
                        <h3 class="pt-4 mb-2 text-2xl">Forgot Your Password?</h3>
                        <p class="mb-4 text-sm text-gray-700">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ session('status') }}
                            </div>
                        @endif

                        <x-validation-errors class="mb-4" />

                    </div>

                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST"
                        action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                                {{ __('Email') }}
                            </label>
                            <input
                                class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow"
                                id="email" name="email" type="email" placeholder="Enter Email Address..."
                                autocomplete="username" :value="old('email')" />
                        </div>
                        <div class="mb-6 text-center">
                            <button
                                class="w-full py-3 font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg border-indigo-500 hover:shadow inline-flex space-x-2 items-center justify-center"
                                type="submit">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                </svg>

                                <span> {{ __('Email Password Reset Link') }}</span>
                            </button>
                        </div>
                        <hr class="mb-6 border-t" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                href="{{ route('register') }}">
                                Create an Account!
                            </a>
                        </div>
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                href="{{ route('login') }}">
                                Already have an account? Login!
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
