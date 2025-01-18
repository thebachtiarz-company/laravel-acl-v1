<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource\Pages;

use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
