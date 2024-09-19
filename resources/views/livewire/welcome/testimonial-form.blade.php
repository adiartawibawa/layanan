@push('styles')
    @filamentStyles
@endpush

<div>
    <x-slot name="page_title">
        Berikan Tanggapan Anda
    </x-slot>

    <x-slot name="page_desc">
        Pengalaman Anda sangat berharga bagi kami. Bagikan pendapat Anda tentang layanan yang telah Anda terima di sini.
        Setiap masukan akan kami gunakan untuk meningkatkan kualitas layanan kami.
    </x-slot>

    <div class="dark:bg-dark mx-auto w-full max-w-2xl rounded-xl ring-1 ring-gray-200 lg:mx-0 lg:flex lg:max-w-none">
        <div class="p-8 sm:p-10 lg:flex-auto">
            <form wire:submit.prevent="create">
                {{ $this->form }}
                <div class="mt-2">
                    <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white"
                        for="rating">Rating</label>
                    <livewire:components.star-rating rating="{{ $rating }}" maxRating="5" :readOnly="false" />
                    @error('rating')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button class="px-3 py-2 bg-primary mt-4 rounded-md text-white" type="submit">
                    Submit
                    Testimonial
                </button>
            </form>
        </div>
    </div>

</div>

@push('scripts')
    @filamentScripts
@endpush
