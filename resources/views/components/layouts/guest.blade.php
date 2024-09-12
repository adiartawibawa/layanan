<x-layouts.landing.landing>
    <!-- ====== Banner Section Start -->
    <div
        class="relative bg-primary shadow-lg z-10 overflow-hidden pt-[120px] pb-[60px] md:pt-[130px] lg:pt-[160px] dark:bg-dark">

        {{ $page_cover ?? '' }}

        <div class="container">
            <div class="flex flex-wrap items-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center">
                        <h1
                            class="mb-4 text-3xl font-bold text-white dark:text-white sm:text-4xl md:text-[40px] md:leading-[1.2]">
                            {{ $page_title ?? 'Page Title' }}
                        </h1>

                        <p class="mb-5 text-base text-white dark:text-dark-6">
                            {{ $page_desc ?? '' }}
                        </p>

                        <div class="flex items-center justify-center gap-[10px]">
                            {{ $additional_item ?? '' }}
                            {{-- <li>
                                <a href="index.html"
                                    class="flex items-center gap-[10px] text-base font-medium text-dark dark:text-white">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                    class="flex items-center gap-[10px] text-base font-medium text-white">
                                    <span class="text-white dark:text-dark-6"> / </span>
                                    Contact us
                                </a>
                            </li> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ====== Banner Section End -->

    <section class="relative py-20 md:py-[60px] px-8 bg-slate-50">
        <div class="container">
            {{ $slot }}
        </div>
    </section>

</x-layouts.landing.landing>
