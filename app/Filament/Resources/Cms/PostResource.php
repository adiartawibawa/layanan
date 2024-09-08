<?php

namespace App\Filament\Resources\Cms;

use App\Filament\Resources\Cms\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

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
                    ->type('post'),
                SpatieMediaLibraryFileUpload::make('featured_image')
                    ->collection('post'),
                Forms\Components\Textarea::make('meta')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('topic.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
        return 1;
    }

    public static function getNavigationGroup(): ?string
    {
        return __("resource.post.nav.group");
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.post.nav.log.label');
    }

    public static function getNavigationIcon(): ?string
    {
        return __('resource.post.nav.log.icon');
    }
}
