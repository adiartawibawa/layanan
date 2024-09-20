<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use App\Concerns\Searchable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    use SoftDeletes;
    use Sluggable;
    use HasUuids;
    use InteractsWithMedia;
    use HasOrganization;
    use HasTags;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    protected $searchableColumns = ['title', 'body']; // Searchable columns

    protected $fullTextSearchableColumns = ['body'];  // Full-Text Search

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'read_time',
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime:Y-m-d',
        'meta' => 'array',
    ];

    public function getFriendlyModelName()
    {
        return 'Berita';
    }

    public function getDisplayableAttribute()
    {
        return $this->title; // Or any logic to choose the most important field
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // Override the route key name to use 'slug' instead of 'id'
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the topic relationship.
     *
     * @return BelongsToMany
     */
    public function topic(): BelongsToMany
    {
        // TODO: This should be a belongsTo() relationship?

        return $this->belongsToMany(
            Topic::class,
            'posts_topics',
            'post_id',
            'topic_id'
        );
    }

    /**
     * Get the user relationship.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the views relationship.
     *
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * Get the visits relationship.
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function getAuthorAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the human-friendly estimated reading time of a given text.
     *
     * @return string
     */
    public function getReadTimeAttribute(): string
    {
        // Only count words in our estimation
        $words = str_word_count(strip_tags($this->body));

        // Divide by the average number of words per minute
        $minutes = ceil($words / 250);

        // The user is optional since we append this attribute
        // to every model and we may be creating a new one
        return vsprintf(
            '%d %s %s',
            [
                $minutes,
                Str::plural(trans('min', [], optional(request()->user())->locale), $minutes),
                trans('baca', [], optional(request()->user())->locale),
            ]
        );
    }

    /**
     * Check to see if the post is published.
     *
     * @return bool
     */
    public function getPublishedAttribute(): bool
    {
        return !is_null($this->published_at) && $this->published_at <= now()->toDateTimeString();
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now()->toDateTimeString());
    }

    /**
     * Scope a query to only include drafted posts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('published_at', '=', null)->orWhere('published_at', '>', now()->toDateTimeString());
    }

    /**
     * Method untuk mendapatkan URL dari gambar post.
     * Jika post tidak memiliki gambar, akan mengembalikan fallback URL.
     *
     * @param string $conversion Nama konversi (opsional, default = null)
     * @return string
     */
    public function getImageUrl(): string
    {
        // Fallback image jika post tidak memiliki media terkait
        $fallbackImage = asset('images/blog/default-banner.png');

        // Mengambil URL gambar pertama dari koleksi 'images', atau fallback jika tidak ada
        return $this->getFirstMediaUrl('post') ?: $fallbackImage;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // filter yang hanya menampilkan record dengan as_page bernilai false
        static::addGlobalScope('as_page', function ($builder) {
            $builder->where('as_page', false);
        });

        static::deleting(function (self $post) {
            $post->tags()->detach();
            $post->topic()->detach();
        });
    }
}
