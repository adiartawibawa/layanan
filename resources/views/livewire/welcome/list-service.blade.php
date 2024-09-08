<div class="-mx-4 flex flex-wrap">
    @foreach ($services as $item)
        <div class="w-full px-4 md:w-1/2 lg:w-1/4">
            <div class="wow fadeInUp group mb-12" data-wow-delay=".1s">
                <div
                    class="relative z-10 mb-10 flex h-[70px] w-[70px] items-center justify-center rounded-[14px] bg-primary">
                    <span
                        class="absolute left-0 top-0 -z-[1] mb-8 flex h-[70px] w-[70px] rotate-[25deg] items-center justify-center rounded-[14px] bg-primary bg-opacity-20 duration-300 group-hover:rotate-45"></span>
                    <svg fill="white" width="37" height="37" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" class="size-6">
                        <path
                            d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 0 1 3.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0 1 21 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 0 1 7.5 16.125V3.375Z" />
                        <path
                            d="M15 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 17.25 7.5h-1.875A.375.375 0 0 1 15 7.125V5.25ZM4.875 6H6v10.125A3.375 3.375 0 0 0 9.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V7.875C3 6.839 3.84 6 4.875 6Z" />
                    </svg>
                </div>
                <h4 class="mb-3 text-xl font-bold text-dark dark:text-white">
                    {{ $item->nama }}
                </h4>
                <p class="mb-8 text-body-color dark:text-dark-6 lg:mb-9">
                    {{ $item->first_five_sentences }}
                </p>
                <a href="layanan/{{ $item->slug }}" target="_blank"
                    class="text-base font-medium text-dark hover:text-primary dark:text-white dark:hover:text-primary">
                    Selengkapnya
                </a>
            </div>
        </div>
    @endforeach
</div>
