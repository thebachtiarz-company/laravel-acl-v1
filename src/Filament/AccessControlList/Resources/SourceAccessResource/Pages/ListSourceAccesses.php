<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource;

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
