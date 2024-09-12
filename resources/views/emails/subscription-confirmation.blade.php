<x-layouts.main>
    <section class="max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-900">
        <header>
            <a href="#">
                <img class="w-auto h-7 sm:h-8" src="#" alt="">
            </a>
        </header>

        <main class="mt-8">
            <h2 class="text-gray-700 dark:text-gray-200">Hi,</h2>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Terima kasih sudah berlangganan dengan email: <span class="font-semibold ">{{ $email }}</span>.
            </p>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Anda sekarang akan menerima informasi terbaru dari kami langsung di kotak masuk Anda.
            </p>

            <p class="mt-8 text-gray-600 dark:text-gray-300">
                Salam Hangat, <br>
                Tim Kami
            </p>
        </main>


        <footer class="mt-8">
            <p class="text-gray-500 dark:text-gray-400">
                Tidak ingin menerima newsletter kami lagi? Klik <a href="#"
                    class="text-sky-700 hover:underline dark:text-sky-700">unsubscribe</a> untuk berhenti berlangganan.
            </p>

            <p class="mt-3 text-gray-500 dark:text-gray-400">© {{ date('Y') }} Layanan. All Rights
                Reserved.</p>
        </footer>
    </section>
</x-layouts.main>
