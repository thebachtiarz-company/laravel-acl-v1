<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserAccesses extends ListRecords
{
    protected static string $resource = UserAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Source')->icon('heroicon-c-plus'),
        ];
    }
}
