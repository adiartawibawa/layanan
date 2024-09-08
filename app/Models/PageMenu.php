<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;

class PageMenu extends Model
{
    use ModelTree;
    use Sluggable;

    protected $table = 'page_menus';

    protected $fillable = ['parent_id', 'title', 'order', 'url'];

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
}
