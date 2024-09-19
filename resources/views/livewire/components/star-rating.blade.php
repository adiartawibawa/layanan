<div>
    <style>
        /* Transisi untuk animasi hover */
        .svg-star {
            transition: transform 0.15s ease-in-out, fill 0.15s ease-in-out;
        }

        /* Saat dihover, bintang akan membesar dan warnanya berubah */
        .svg-star:hover {
            transform: scale(1.25);
            fill: rgb(255, 225, 0);
            color: yellow;
        }
    </style>

    <div class="flex items-center gap-1" id="starRatingContainer">
        @for ($i = 1; $i <= $maxRating; $i++)
            <svg data-rating="{{ $i }}" wire:click="setRating({{ $i }})"
                xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $rating ? 'yellow' : 'none' }}" viewBox="0 0 24 24"
                stroke="currentColor"
                class="cursor-pointer transition-all transform hover:scale-125 hover:fill-yellow-400 hover:text-yellow-400 {{ $styleClass }} {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-400' }}"
                @if ($readOnly) style="pointer-events: none;" @endif>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 2l2.39 7.26L22 9.27l-5.61 4.09L17.45 22 12 18.18 6.55 22l1.06-8.64L2 9.27l7.61-1.01L12 2z" />
            </svg>
        @endfor
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#starRatingContainer svg');

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('data-rating');
                    highlightStars(rating);
                });

                star.addEventListener('mouseleave', function() {
                    resetStars();
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    if (star.getAttribute('data-rating') <= rating) {
                        star.style.fill = 'yellow';
                    } else {
                        star.style.fill = 'none';
                    }
                });
            }

            function resetStars() {
                const currentRating = @json($rating); // Nilai rating saat ini dari Livewire
                stars.forEach(star => {
                    if (star.getAttribute('data-rating') <= currentRating) {
                        star.style.fill = 'yellow';
                    } else {
                        star.style.fill = 'none';
                    }
                });
            }
        });
    </script>
</div>
