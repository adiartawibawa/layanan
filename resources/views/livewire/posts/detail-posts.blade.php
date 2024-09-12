<div class="flex flex-wrap items-center -mx-4">
    <x-slot name="page_cover">
        <div style="background-image: url('{{ $post->getImageUrl() }}')"
            class="absolute bottom-0 left-0 w-full min-h-[500px] bg-cover">
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
            <div class="bg-white relative top-0 -mt-32 p-5 sm:p-10 z-50">
                <h1 href="#" class="text-gray-900 font-bold text-3xl mb-2">{{ $post->title }}</h1>
                <p class="text-gray-700 text-xs mt-2">Ditulis oleh:
                    <a href="#"
                        class="text-primary font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                        {{ $post->author }}
                    </a> In
                    @foreach ($post->tags as $tag)
                        <a href="#"
                            class="text-xs text-primary font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                            <span class="relative">#{{ $tag->name }}</span>
                        </a>
                    @endforeach
                </p>

                <div class="text-base my-5 prose lg:prose-lg">
                    {!! $post->body !!}
                </div>

                @foreach ($post->tags as $tag)
                    <a href="#"
                        class="text-xs text-primary font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                        #{{ $tag->name }}
                    </a>,
                @endforeach
            </div>

        </div>
    </div>
</div>
