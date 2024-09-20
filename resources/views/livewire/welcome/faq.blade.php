<div class="bg-white dark:bg-dark w-full px-4">
    <div class="py-6 mx-auto">
        <div class="mt-8 xl:mt-16 lg:flex lg:-mx-12">
            <!-- Sidebar Table of Content -->
            <div class="lg:mx-12">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Layanan yang Sering Ditanyakan</h1>

                <div class="mt-4 space-y-4 lg:mt-8">
                    @foreach ($categories as $category)
                        <a href="#" wire:click.prevent="setActiveCategory({{ $category->id }})"
                            class="block {{ $category->id === $activeCategory ? 'text-primary dark:text-red-400' : 'text-gray-500 dark:text-gray-300' }} hover:underline
                           {{ $category->id === $activeCategory ? 'font-bold' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="flex-1 mt-8 lg:mx-12 lg:mt-0">
                @forelse($faqs as $faq)
                    <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-8 mb-8 my-8">
                        <button @click="open = !open"
                            class="flex items-center focus:outline-none w-full justify-between">
                            <div class="flex items-center">
                                <svg x-show="open" class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>

                                <h1 class="mx-4 text-xl text-gray-700 dark:text-white">
                                    {{ $faq->question }}
                                </h1>
                            </div>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2" class="flex mt-8 md:mx-10">
                            <span x-show="open" class="border border-primary"></span>
                            <p class="max-w-3xl px-4 text-gray-500 dark:text-gray-300">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-300">
                        Tidak ada FAQ untuk kategori ini.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
