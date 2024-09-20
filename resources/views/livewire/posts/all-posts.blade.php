<div>
    @if ($viewMode === 'list')
        {{-- List View --}}
        @foreach ($posts as $post)
            <a href="{{ route('berita.detail', $post->slug) }}"
                class="group flex flex-col md:flex-row items-center gap-4 mb-4">
                <div class="w-full md:w-1/4">
                    <img src="{{ $post->getImageUrl() }}" alt="blog"
                        class="w-full h-auto rounded object-cover transition-transform duration-300 ease-in-out transform group-hover:scale-105" />
                </div>
                <span class="w-full md:w-3/4 text-base text-gray-7 group-hover:text-white">
                    {{ Str::limit($post->title, 80) }}
                </span>
            </a>

            {{-- Optional Post Details (publish date, author, read time) --}}
            @if ($showDetails['publish_date'] || $showDetails['author'] || $showDetails['read_time'])
                <div class="mt-2 text-xs text-gray-500">
                    @if ($showDetails['publish_date'])
                        <span>{{ $post->published_at->format('d M Y') }}</span>
                    @endif
                    @if ($showDetails['author'])
                        <span>by {{ $post->author }}</span>
                    @endif
                    @if ($showDetails['read_time'])
                        <span>{{ $post->read_time }}</span>
                    @endif
                </div>
            @endif
        @endforeach
    @else
        {{-- Card View --}}
        <div class="-mx-4 flex flex-wrap">
            @foreach ($posts as $post)
                <div class="w-full px-4 md:w-1/2 lg:w-1/3">
                    <div class="group mb-10">
                        <div class="mb-8 overflow-hidden rounded-[5px]">
                            <a href="{{ route('berita.detail', $post->slug) }}" class="block">
                                <img src="{{ $post->getImageUrl() }}" alt="image"
                                    class="w-full md:h-64 object-cover transition group-hover:rotate-6 group-hover:scale-125" />
                            </a>
                        </div>
                        <div>
                            <h3>
                                <a href="{{ route('berita.detail', $post->slug) }}"
                                    class="mb-4 inline-block text-xl font-semibold text-dark hover:text-primary">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <div class="mb-3 text-xs text-slate-500">
                                @if ($showDetails['publish_date'])
                                    <span>{{ $post->published_at->format('d M Y') }}</span>
                                @endif
                                <span> . </span>
                                @if ($showDetails['read_time'])
                                    <span>{{ $post->read_time }}</span>
                                @endif
                            </div>
                            <p class="max-w-[370px] text-base text-body-color">
                                {!! Str::limit($post->body, 250) !!}
                            </p>
                            <div class="mt-2 flex gap-2 flex-wrap">
                                @foreach ($post->tags as $tag)
                                    <a href="#" class="relative hover:text-primary">#{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Optional Infinite Scroll --}}
    @if ($infiniteScroll)
        <div wire:loading>Loading...</div>
        <button wire:click="loadMore" class="mt-4 px-4 py-2 bg-primary text-white">Load More</button>
    @endif
</div>
