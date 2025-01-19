<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource;

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
