<div class="container mx-auto py-8" x-data="{ step: @entangle('step'), loading: @entangle('loading'), progress: @entangle('progress') }">
    <div class="max-w-full mx-auto">
        <form wire:submit.prevent="submit" x-on:submit="loading = true">
            {{ $this->form }}
        </form>
    </div>

    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-500 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
