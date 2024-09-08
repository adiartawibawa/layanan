<?php

namespace App\Filament\Resources\Cms;

use App\Filament\Resources\Cms\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Spatie\Tags\Tag;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('user_id')
                //     ->label('Author')
                //     ->relationship('user', 'name')
                //     ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin']))
                //     ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('body')
                    ->label('Content')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\Select::make('topic')
                    ->multiple()
                    ->label('Topik')
                    ->relationship('topic', 'name')
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                        Hidden::make('user_id')->default(Auth::user()->id)
                    ]),
                SpatieTagsInput::make('tags')
                    ->suggestions(Tag::all()->pluck('name'))
                    ->separator(',')
                    ->splitKeys(['Tab', ' '])
                    ->reorderable()
                    ->type('page'),
                SpatieMediaLibraryFileUpload::make('featured_image')
                    ->collection('page'),
                Forms\Components\Textarea::make('meta')
                    ->columnSpanFull(),
                Hidden::make('as_page')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationSort(): ?int
    {
        return 0;
    }

    public static function getNavigationGroup(): ?string
    {
        return __("resource.page.nav.group");
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.page.nav.log.label');
    }

    public static function getNavigationIcon(): ?string
    {
        return __('resource.page.nav.log.icon');
    }
}
