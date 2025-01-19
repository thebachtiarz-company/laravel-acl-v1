<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource;

class EditUserAccess extends EditRecord
{
    protected static string $resource = UserAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Delete')->icon('heroicon-s-trash'),
        ];
    }
}
