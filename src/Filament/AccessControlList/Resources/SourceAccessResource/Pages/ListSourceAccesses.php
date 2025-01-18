<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;

use App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSourceAccesses extends ListRecords
{
    protected static string $resource = SourceAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Source')->icon('heroicon-c-plus'),
        ];
    }
}
