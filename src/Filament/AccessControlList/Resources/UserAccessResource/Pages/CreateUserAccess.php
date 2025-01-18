<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use App\Libraries\MyACL\DTO\Services\UserAccessMutationInputDTO;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\UserAccessResource;
use App\Libraries\MyACL\Interfaces\Models\UserAccessInterface;
use App\Libraries\MyACL\Interfaces\Services\UserAccessServiceInterface;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

class CreateUserAccess extends CreateRecord
{
    protected static string $resource = UserAccessResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $process = app(UserAccessServiceInterface::class)->createOrReplace(new UserAccessMutationInputDTO(
            userId: $data[UserAccessInterface::ATTRIBUTE_USER_ID],
            sourceAccessId: $data[UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID],
            accessManagerId: $data[UserAccessInterface::ATTRIBUTE_ACCESS_MANAGER_ID],
        ));

        if (!$process->condition->toBoolean()) {
            Notification::make()
                ->warning()
                ->title($process->message)
                ->send();

            throw new Halt();
        }

        return $process->model;
    }
}
