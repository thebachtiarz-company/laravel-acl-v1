<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource;

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
