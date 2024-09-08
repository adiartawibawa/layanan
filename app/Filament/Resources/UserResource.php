<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\StatsUsers;
use App\Filament\Resources\UserResource\Widgets\UsersByRole;
use App\Models\User;
use App\Settings\MailSettings;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static int $globalSearchResultsLimit = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->hiddenLabel()
                                    ->avatar()
                                    ->collection('avatars')
                                    ->alignCenter()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('username')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('firstname')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('lastname')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Role')
                            ->schema([
                                Select::make('roles')
                                    ->label('Role')
                                    ->hiddenLabel()
                                    ->relationship('roles', 'name', function ($query) {
                                        if (!Auth::user()->isSuperAdmin()) {
                                            $query->where('name', '!=', config('filament-shield.super_admin.name'));
                                        }
                                    })
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                                    ->multiple()
                                    ->preload()
                                    ->native(false)
                            ])
                            ->compact(),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->revealable()
                                    ->required(),
                                Forms\Components\TextInput::make('passwordConfirmation')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->revealable()
                                    ->same('password')
                                    ->required(),
                            ])
                            ->compact()
                            ->hidden(fn (string $operation): bool => $operation === 'edit'),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('email_verified_at')
                                    ->label(__('resource.general.email_verified_at'))
                                    ->content(fn (User $record): ?string => $record->email_verified_at),
                                Actions::make([
                                    Action::make('resend_verification')
                                        ->label(__('resource.user.actions.resend_verification'))
                                        ->color('secondary')
                                        ->action(fn (MailSettings $settings, Model $record) => static::doResendEmailVerification($settings, $record)),
                                ])
                                    ->hidden(fn (User $user) => $user->email_verified_at != null)
                                    ->fullWidth(),
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('resource.general.created_at'))
                                    ->content(fn (User $record): ?string => $record->created_at?->diffForHumans()),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('resource.general.updated_at'))
                                    ->content(fn (User $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->hidden(fn (string $operation): bool => $operation === 'create'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular()
                    ->extraImgAttributes(fn (User $record): array => [
                        'alt' => "{$record->name} avatar",
                        'loading' => 'lazy'
                    ])
                    ->wrap(),
                Tables\Columns\TextColumn::make('username')
                    ->description(fn (Model $record) => $record->firstname . ' ' . $record->lastname)
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->colors(['info'])
                    ->badge(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->email;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['email', 'username'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'name' => $record->firstname . ' ' . $record->lastname,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function doResendEmailVerification($settings = null, $user): void
    {
        if (!method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = new VerifyEmail();
        $notification->url = Filament::getVerifyEmailUrl($user);

        $settings->loadMailSettingsToConfig();

        $user->notify($notification);

        Notification::make()
            ->title(__('resource.user.notifications.notification_resent.title'))
            ->success()
            ->send();
    }

    public static function getNavigationLabel(): string
    {
        return __("resource.user.nav.label");
    }

    public static function getNavigationIcon(): ?string
    {
        return __("resource.user.nav.icon");
    }
}
