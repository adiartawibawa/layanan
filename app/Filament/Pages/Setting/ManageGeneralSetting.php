<?php

namespace App\Filament\Pages\Setting;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class ManageGeneralSetting extends SettingsPage
{
    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('app_name')
                    ->label(fn () => __("page.general_settings.fields.app_name"))
                    ->required(),
                Textarea::make('app_desc')
                    ->label(fn () => __("page.general_settings.fields.app_desc"))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('app_phone')
                    ->label(fn () => __("page.general_settings.fields.app_contact"))
                    ->required(),
                TextInput::make('app_mail')
                    ->label(fn () => __("page.general_settings.fields.app_mail"))
                    ->required(),
                TimezoneSelect::make('app_timezone')
                    ->label(fn () => __("page.general_settings.fields.app_timezone"))
                    ->timezoneType('UTC')
                    ->searchable()
                    ->required(),
                Select::make('app_locale')
                    ->label(fn () => __("page.general_settings.fields.app_locale"))
                    ->options([
                        'id' => 'ID - Indonesia',
                        'en' => 'EN - English(US)',
                    ])
                    ->required(),
                FileUpload::make('app_favicon')
                    ->directory('settings/general')
                    ->label(fn () => __("page.general_settings.fields.site_favicon")),
                FileUpload::make('app_logo')
                    ->directory('settings/general')
                    ->label(fn () => __("page.general_settings.fields.app_logo")),
                Toggle::make('app_active')
                    ->label(fn () => __("page.general_settings.fields.site_active"))
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-bolt-slash')
                    ->default(true),
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __("page.general_settings.nav.group");
    }

    public static function getNavigationIcon(): ?string
    {
        return __('page.general_settings.nav.icon');
    }

    public static function getNavigationLabel(): string
    {
        return __("page.general_settings.navigationLabel");
    }

    public function getTitle(): string
    {
        return __("page.general_settings.title");
    }

    public function getHeading(): string
    {
        return __("page.general_settings.heading");
    }

    public function getSubheading(): string
    {
        return __("page.general_settings.subheading");
    }
}
