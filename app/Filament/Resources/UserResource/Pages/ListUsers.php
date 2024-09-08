<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    // Specifies the resource that this page is related to
    protected static string $resource = UserResource::class;

    // Defines the actions that will appear in the header of the page
    protected function getHeaderActions(): array
    {
        // Return an array of actions, in this case, only a "Create" action to add a new user
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Retrieves widgets that will be displayed in the header of the page
    protected function getHeaderWidgets(): array
    {
        // Return the widgets defined in the UserResource class
        return static::$resource::getWidgets();
    }

    // Defines the tabs that will be displayed on the page
    public function getTabs(): array
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Define default tabs
        $tabs = [
            null => Tab::make('All'), // Tab to show all users
            'admin' => Tab::make()->query(fn ($query) => $query->with('roles')->whereRelation('roles', 'name', '=', 'admin')), // Tab to show users with the 'admin' role
        ];

        // If the current user is a super admin, add a specific tab for super admins
        if ($user->isSuperAdmin()) {
            $tabs['super admin'] = Tab::make()->query(fn ($query) => $query->with('roles')->whereRelation('roles', 'name', '=', config('filament-shield.super_admin.name')));
        }

        return $tabs;
    }

    // Defines the query used to retrieve users for the table on this page
    protected function getTableQuery(): Builder
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Start with a query to get all users, excluding the currently authenticated user
        $model = (new (static::$resource::getModel()))->with('roles')->where('id', '!=', $user->id);

        // If the current user is not a super admin, exclude users with the 'super_admin' role
        if (!$user->isSuperAdmin()) {
            $model = $model->whereDoesntHave('roles', function ($query) {
                $query->where('name', '=', config('filament-shield.super_admin.name'));
            });
        }

        return $model;
    }
}
