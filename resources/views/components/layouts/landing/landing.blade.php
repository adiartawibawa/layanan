<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="name" content="{{ $meta['app_name'] }}" />
    <meta name="description" content="{{ $meta['app_desc'] }}" />
    <meta name="province" content="{{ $meta['app_address_province'] }}" />
    <meta name="city" content="{{ $meta['app_address_city'] }}" />
    <meta name="address" content="{{ $meta['app_address_street'] }}" />
    <meta name="phone" content="{{ $meta['app_phone'] }}" />
    <meta name="mail" content="{{ $meta['app_mail'] }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title') - {{ $meta['app_name'] ?? config('app.name') }}</title>
    @else
        <title>{{ $meta['app_name'] ?? config('app.name') }}</title>
    @endif

    <link rel="shortcut icon" href="{{ $meta['app_favicon'] }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />

    @stack('styles')

    @vite('resources/css/app.css')
    @vite('resources/css/landing/landing.css')

    <!-- ==== WOW JS ==== -->
    <script src="{{ asset('js/wow.min.js') }}"></script>

    <script>
        new WOW().init();
    </script>
</head>

<body>
    @include('components.layouts.landing.partials.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('components.layouts.landing.partials.footer')

    @livewire('notifications')

    <!-- ====== Back To Top Start -->
    <a href="javascript:void(0)"
        class="back-to-top fixed bottom-8 left-auto right-8 z-[999] hidden h-10 w-10 items-center justify-center rounded-md bg-primary text-white shadow-md transition duration-300 ease-in-out hover:bg-dark">
        <span class="mt-[6px] h-3 w-3 rotate-45 border-l border-t border-white"></span>
    </a>
    <!-- ====== Back To Top End -->

    <!-- ====== All Scripts -->

    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>

    @vite('resources/js/app.js')

    @vite('resources/js/landing.js')

    @stack('scripts')

</body>

</html>
