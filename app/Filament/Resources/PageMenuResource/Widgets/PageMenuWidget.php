<?php

namespace App\Filament\Resources\PageMenuResource\Widgets;

use App\Models\PageMenu;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class PageMenuWidget extends BaseWidget
{
    protected static string $model = PageMenu::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'Page Menu List';

    protected bool $enableTreeTitle = true;
}
