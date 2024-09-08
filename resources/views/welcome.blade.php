<x-layouts.landing.landing>
    @push('styles')
        {{--  --}}
    @endpush

    @include('welcome.hero')

    @include('welcome.about')

    @include('welcome.map')

    @include('welcome.cta')

    @include('welcome.team')

    @include('welcome.contact')

    @include('welcome.service')

    @include('welcome.blog')

    @include('welcome.testimonials')

    @include('welcome.faq')

    @push('scripts')
        <script>
            // ==== for menu scroll
            const pageLink = document.querySelectorAll(".ud-menu-scroll");

            pageLink.forEach((elem) => {
                elem.addEventListener("click", (e) => {
                    e.preventDefault();
                    document.querySelector(elem.getAttribute("href")).scrollIntoView({
                        behavior: "smooth",
                        offsetTop: 1 - 60,
                    });
                });
            });

            // section menu active
            function onScroll(event) {
                const sections = document.querySelectorAll(".ud-menu-scroll");
                const scrollPos =
                    window.pageYOffset ||
                    document.documentElement.scrollTop ||
                    document.body.scrollTop;

                for (let i = 0; i < sections.length; i++) {
                    const currLink = sections[i];
                    const val = currLink.getAttribute("href");
                    const refElement = document.querySelector(val);
                    const scrollTopMinus = scrollPos + 73;
                    if (
                        refElement.offsetTop <= scrollTopMinus &&
                        refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
                    ) {
                        document
                            .querySelector(".ud-menu-scroll")
                            .classList.remove("active");
                        currLink.classList.add("active");
                    } else {
                        currLink.classList.remove("active");
                    }
                }
            }

            window.document.addEventListener("scroll", onScroll);

            // Testimonial
            const testimonialSwiper = new Swiper(".testimonial-carousel", {
                slidesPerView: 1,
                spaceBetween: 30,

                // Navigation arrows
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },

                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1280: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
            });
        </script>
    @endpush
</x-layouts.landing.landing>
