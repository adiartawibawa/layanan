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

    <script>
        // ==== for menu scroll ====
        // Mengambil URL root saat ini
        const baseUrl = window.location.origin; // http://layanan.test
        const currentPath = window.location.pathname; // Path halaman saat ini

        // Mengambil semua elemen menu dengan kelas 'ud-menu-scroll'
        const pageLink = document.querySelectorAll(".ud-menu-scroll");

        pageLink.forEach((elem) => {
            elem.addEventListener("click", (e) => {
                e.preventDefault();

                // Mendapatkan target dari href, contoh: '#home'
                const targetSection = elem.getAttribute("href");

                // Modifikasi href sementara hanya saat klik terjadi
                elem.setAttribute('href', baseUrl + "/" + targetSection);

                // Jika saat ini tidak berada di halaman root atau base URL
                if (currentPath !== "/") {
                    // Arahkan ke halaman utama (root) dengan menambahkan targetSection di akhir URL
                    window.location.href = baseUrl + "/" + targetSection;
                } else {
                    // Jika sudah di halaman root, gulir ke bagian yang sesuai dengan animasi halus
                    document.querySelector(targetSection).scrollIntoView({
                        behavior: "smooth",
                        offsetTop: 1 - 60,
                    });
                }

                // Setelah klik selesai, reset href kembali ke nilai asalnya
                elem.setAttribute('href', targetSection);
            });
        });

        // ==== section menu active ====
        // Fungsi untuk menentukan elemen menu mana yang sedang aktif berdasarkan posisi scroll
        function onScroll(event) {
            // Mengambil semua elemen menu dengan kelas 'ud-menu-scroll'
            const sections = document.querySelectorAll(".ud-menu-scroll");

            // Mendapatkan posisi scroll saat ini (dari berbagai kemungkinan sumber)
            const scrollPos =
                window.pageYOffset || // Untuk browser modern
                document.documentElement.scrollTop || // Untuk browser berbasis DOM
                document.body.scrollTop; // Untuk browser lama

            // Looping melalui setiap elemen menu
            for (let i = 0; i < sections.length; i++) {
                const currLink = sections[i]; // Elemen link saat ini
                const val = currLink.getAttribute("href"); // Mengambil nilai 'href' (target ID bagian)
                const refElement = document.querySelector(val); // Mengambil elemen target (bagian yang terkait)
                const scrollTopMinus = scrollPos + 73; // Koreksi posisi scroll dengan menambahkan 73px

                // Memeriksa apakah posisi scroll saat ini berada di dalam area bagian yang sedang diperiksa
                if (
                    refElement.offsetTop <= scrollTopMinus && // Bagian berada di atas atau di dekat posisi scroll
                    refElement.offsetTop + refElement.offsetHeight > scrollTopMinus // Bagian belum melewati posisi scroll
                ) {
                    // Menghapus kelas 'active' dari elemen menu yang sudah aktif
                    document
                        .querySelector(".ud-menu-scroll.active")
                        ?.classList.remove("active");

                    // Menambahkan kelas 'active' ke elemen menu yang sesuai
                    currLink.classList.add("active");
                } else {
                    // Jika bagian tidak sedang aktif, menghapus kelas 'active'
                    currLink.classList.remove("active");
                }
            }
        }

        // Menambahkan event listener untuk 'scroll' yang memicu fungsi onScroll ketika halaman di-scroll
        window.document.addEventListener("scroll", onScroll);

        // ==== Testimonial ====
        // Membuat instance baru dari Swiper untuk carousel testimonial
        const testimonialSwiper = new Swiper(".testimonial-carousel", {
            // Jumlah slide yang ditampilkan dalam satu baris
            slidesPerView: 1,
            // Jarak antar slide
            spaceBetween: 30,

            // Navigasi panah
            navigation: {
                nextEl: ".swiper-button-next", // Elemen untuk tombol berikutnya
                prevEl: ".swiper-button-prev", // Elemen untuk tombol sebelumnya
            },

            // Pengaturan tampilan berdasarkan ukuran layar (breakpoints)
            breakpoints: {
                640: {
                    // Untuk layar dengan lebar minimal 640px, tampilkan 2 slide
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    // Untuk layar dengan lebar minimal 1024px, tampilkan 3 slide
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    // Untuk layar dengan lebar minimal 1280px, tampilkan 3 slide
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    </script>

</body>

</html>
