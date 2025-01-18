<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
