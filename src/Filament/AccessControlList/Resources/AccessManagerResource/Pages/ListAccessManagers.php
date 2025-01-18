<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;

use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessManagers extends ListRecords
{
    protected static string $resource = AccessManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Source')->icon('heroicon-c-plus'),
        ];
    }
}
