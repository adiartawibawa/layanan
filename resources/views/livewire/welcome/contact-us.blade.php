<div class="wow fadeInUp rounded-lg bg-white px-8 py-10 shadow-testimonial dark:bg-dark-2 dark:shadow-none sm:px-10 sm:py-12 md:p-[60px] lg:p-10 lg:px-10 lg:py-12 2xl:p-[60px]"
    data-wow-delay=".2s">
    <h3 class="mb-8 text-2xl font-semibold text-dark dark:text-white md:text-[28px] md:leading-[1.42]">
        Kirimkan Pesan kepada kami
    </h3>
    {{-- <form>
        <div class="mb-[22px]">
            <label for="fullName" class="mb-4 block text-sm text-body-color dark:text-dark-6">Full
                Name*</label>
            <input type="text" name="fullName" placeholder="Adam Gelius"
                class="w-full border-0 border-b border-[#f1f1f1] bg-transparent pb-3 text-body-color placeholder:text-body-color/60 focus:border-primary focus:outline-none dark:border-dark-3 dark:text-dark-6" />
        </div>
        <div class="mb-[22px]">
            <label for="email" class="mb-4 block text-sm text-body-color dark:text-dark-6">Email*</label>
            <input type="email" name="email" placeholder="example@yourmail.com"
                class="w-full border-0 border-b border-[#f1f1f1] bg-transparent pb-3 text-body-color placeholder:text-body-color/60 focus:border-primary focus:outline-none dark:border-dark-3 dark:text-dark-6" />
        </div>
        <div class="mb-[22px]">
            <label for="phone" class="mb-4 block text-sm text-body-color dark:text-dark-6">Phone*</label>
            <input type="text" name="phone" placeholder="+885 1254 5211 552"
                class="w-full border-0 border-b border-[#f1f1f1] bg-transparent pb-3 text-body-color placeholder:text-body-color/60 focus:border-primary focus:outline-none dark:border-dark-3 dark:text-dark-6" />
        </div>
        <div class="mb-[30px]">
            <label for="message" class="mb-4 block text-sm text-body-color dark:text-dark-6">Message*</label>
            <textarea name="message" rows="1" placeholder="type your message here"
                class="w-full resize-none border-0 border-b border-[#f1f1f1] bg-transparent pb-3 text-body-color placeholder:text-body-color/60 focus:border-primary focus:outline-none dark:border-dark-3 dark:text-dark-6"></textarea>
        </div>
        <div class="mb-0">
            <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-primary px-10 py-3 text-base font-medium text-white transition duration-300 ease-in-out hover:bg-red-dark">
                Kirim
            </button>
        </div>
    </form> --}}
    <form wire:submit="create">
        {{ $this->form }}

        <div class="mt-4 mb-0">
            {{-- <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-primary px-10 py-3 text-base font-medium text-white transition duration-300 ease-in-out hover:bg-red-dark">
                <span>Kirim</span>
            </button> --}}
            {{ $this->create }}
        </div>
    </form>

    <x-filament-actions::modals />
</div>
