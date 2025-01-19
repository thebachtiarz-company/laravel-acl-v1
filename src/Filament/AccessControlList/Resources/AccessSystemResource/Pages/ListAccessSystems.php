<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource;

class ListAccessSystems extends ListRecords
{
    protected static string $resource = AccessSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Source')->icon('heroicon-c-plus'),
        ];
    }
}
