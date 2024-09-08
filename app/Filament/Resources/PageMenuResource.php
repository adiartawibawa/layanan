<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageMenuResource\Pages;
use App\Filament\Resources\PageMenuResource\RelationManagers;
use App\Models\PageMenu;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageMenuResource extends Resource
{
    protected static ?string $model = PageMenu::class;

    // you can customize the maximum depth of your tree
    protected static int $maxDepth = 2;

    // protected ?string $treeTitle = 'Menu Page';

    protected bool $enableTreeTitle = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('url'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\PageMenuTree::route('/')
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationGroup(): ?string
    {
        return __("resource.menu.nav.group");
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.menu.nav.log.label');
    }

    public static function getNavigationIcon(): ?string
    {
        return __('resource.menu.nav.log.icon');
    }
}
