<div class="swiper testimonial-carousel common-carousel p-5">

    <div class="swiper-wrapper">
        @foreach ($testimonials as $testimonial)
            <div class="swiper-slide">
                <div class="rounded-xl bg-white px-4 py-[30px] shadow-testimonial dark:bg-dark sm:px-[30px]">
                    <div class="mb-[18px] flex items-center gap-[2px]">

                        <livewire:components.star-rating rating="{{ $testimonial->rating }}" styleClass="w-4 h-4"
                            maxRating="5" :readOnly="true" />
                    </div>

                    <p class="mb-6 text-base text-body-color dark:text-dark-6 italic">
                        “{{ $testimonial->message }}”
                    </p>

                    <a href="#" class="flex items-center gap-4">
                        <div class="h-[50px] w-[50px] overflow-hidden rounded-full">
                            <img src="{{ $testimonial->getAvatarUrl() }}" alt="avatar {{ $testimonial->name }}"
                                class="h-[50px] w-[50px] overflow-hidden rounded-full" />
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-dark dark:text-white">
                                {{ $testimonial->name }}
                            </h3>
                            <p class="text-xs text-body-secondary">{{ $testimonial->position }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-[60px] flex items-center justify-center gap-1">
        <div class="swiper-button-prev">
            <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19.25 10.2437H4.57187L10.4156 4.29687C10.725 3.9875 10.725 3.50625 10.4156 3.19687C10.1062 2.8875 9.625 2.8875 9.31562 3.19687L2.2 10.4156C1.89062 10.725 1.89062 11.2063 2.2 11.5156L9.31562 18.7344C9.45312 18.8719 9.65937 18.975 9.86562 18.975C10.0719 18.975 10.2437 18.9062 10.4156 18.7687C10.725 18.4594 10.725 17.9781 10.4156 17.6688L4.60625 11.7906H19.25C19.6625 11.7906 20.0063 11.4469 20.0063 11.0344C20.0063 10.5875 19.6625 10.2437 19.25 10.2437Z" />
            </svg>
        </div>

        <div class="swiper-button-next">
            <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19.8 10.45L12.6844 3.2313C12.375 2.92192 11.8938 2.92192 11.5844 3.2313C11.275 3.54067 11.275 4.02192 11.5844 4.3313L17.3594 10.2094H2.75C2.3375 10.2094 1.99375 10.5532 1.99375 10.9657C1.99375 11.3782 2.3375 11.7563 2.75 11.7563H17.4281L11.5844 17.7032C11.275 18.0126 11.275 18.4938 11.5844 18.8032C11.7219 18.9407 11.9281 19.0094 12.1344 19.0094C12.3406 19.0094 12.5469 18.9407 12.6844 18.7688L19.8 11.55C20.1094 11.2407 20.1094 10.7594 19.8 10.45Z" />
            </svg>
        </div>
    </div>
</div>


@push('scripts')
    <script>
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
@endpush
