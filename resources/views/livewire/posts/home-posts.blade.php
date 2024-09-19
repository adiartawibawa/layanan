<div class="-mx-4 flex flex-wrap gap-4">
    @forelse ($posts as $post)
        <div class="w-full md:w-1/2 rounded-lg lg:w-1/3 dark:bg-slate-900 bg-slate-100">
            <div class="wow fadeInUp group mb-10" data-wow-delay=".1s">
                <div class="mb-8 overflow-hidden rounded-[5px]">
                    <a href="{{ route('berita.detail', $post->slug) }}" class="block">
                        <img src="{{ $post->getImageUrl() }}" alt="image"
                            class="w-full md:h-64 object-cover transition group-hover:rotate-6 group-hover:scale-125" />
                    </a>
                </div>
                <div class="px-4 dark:text-white">
                    <h3>
                        <a href="{{ route('berita.detail', $post->slug) }}"
                            class="mb-4 inline-block text-xl font-semibold text-dark hover:text-primary dark:text-white dark:hover:text-primary sm:text-2xl lg:text-xl xl:text-2xl">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="mb-3 inline-flex gap-1 text-xs font-medium leading-loose text-slate-500">
                        {{ date('d M Y', strtotime($post->published_at)) }}
                        <span> . </span>
                        {{ $post->read_time }}
                    </div>
                    <p class="max-w-[370px] text-base text-body-color dark:text-dark-6">
                        {!! \Illuminate\Support\Str::limit($post->body, 250) !!}
                        <a href="{{ route('berita.detail', $post->slug) }}" class="text-primary text-sm">Baca
                            Selengkapnya</a>
                    </p>
                    <div class="mt-2 flex gap-2 flex-wrap">
                        @foreach ($post->tags as $tag)
                            <a href="#"
                                class="cursor-pointer relative before:absolute before:bg-primary before:bottom-0 before:left-0 before:h-full before:w-full before:origin-bottom before:scale-y-[0.15] hover:before:scale-y-100 before:transition-transform before:ease-in-out before:duration-500 hover:text-white">
                                <span class="relative">#{{ $tag->name }}</span>
                            </a>
                        @endforeach
                    </div>
                    {{-- <a href="{{ route('post.show', $post->slug) }}" class="text-primary text-sm">Baca Selengkapnya</a> --}}
                </div>
            </div>
        </div>
    @empty
        <p>Belum ada berita</p>
    @endforelse
</div>
