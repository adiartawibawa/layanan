<!-- ====== Map Start ====== -->
<section id="sekolah" class="relative py-20 md:py-[120px]">
    <div class="absolute left-0 top-0 -z-[1] h-full w-full dark:bg-dark"></div>
    <div class="absolute left-0 top-0 -z-[1] h-1/2 w-full bg-[#E9F9FF] dark:bg-dark-700 lg:h-[45%] xl:h-1/2">
    </div>
    <div class="container px-4">
        <div class="-mx-4 flex flex-wrap items-start">
            <div class="w-full px-4 lg:w-7/12 xl:w-7/12">
                <div class="ud-contact-content-wrapper">
                    <div class="ud-contact-title mb-12 lg:mb-[150px]">
                        <span class="mb-6 uppercase block text-base font-medium text-primary dark:text-primary">
                            Sekolah Kami
                        </span>
                        <h2 class="max-w-[460px] text-[35px] font-semibold leading-[1.14] text-dark dark:text-white">
                            Jelajah Sekolah di Kabupaten Badung
                        </h2>
                        <p class="mt-4 mb-6  text-base text-dark-4">
                            Temukan lokasi dan informasi lengkap tentang sekolah -sekolah yang berada dibawah naungan
                            Bidang SD Dinas Pendidikan, Kepemudaan dan Olahraga Kabupaten Badung
                            melalui
                            peta interaktif kami. Peta ini membantu orang tua, siswa, dan masyarakat untuk mencari dan
                            mengetahui detail penting seperti alamat, kontak, dan fasilitas setiap sekolah. Jelajahi
                            sekarang dan temukan sekolah yang tepat untuk kebutuhan pendidikan Anda.
                        </p>
                        <a href="{{ route('sekolah.map') }}" target="_blank"
                            class="inline-flex items-center justify-center rounded-md border border-primary bg-primary px-7 py-3 text-center text-base font-medium text-white hover:border-red-dark hover:bg-red-dark">
                            Jelajahi Sekarang
                        </a>
                    </div>
                    <div class="mb-12 flex flex-wrap justify-between lg:mb-0">
                        <div class="mb-8 flex w-[330px] max-w-full">
                            <div class="mr-6 text-[32px] text-primary">
                                <svg width="29" height="35" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                            </div>
                            <div>
                                @livewire('welcome.sekolah-overview')
                            </div>
                        </div>
                        <div class="mb-8 flex w-[330px] max-w-full">
                            <div class="mr-6 text-[32px] text-primary">
                                <svg width="34" height="25" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <div>
                                @livewire('welcome.gtk-overview')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-5/12 xl:w-5/12">
                <div class="wow fadeInUp rounded-lg bg-transparent px-8 py-10 sm:px-6 sm:py-8 md:p-[60px] lg:p-6 lg:px-6 lg:py-8 2xl:p-[60px]"
                    data-wow-delay=".2s">
                    {{-- map goes here --}}
                    @livewire('welcome.map')
                </div>
            </div>
        </div>
    </div>


</section>
<!-- ====== Map End ====== -->
