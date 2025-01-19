<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\DTO\Services\UserAccessMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource;
use TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
use TheBachtiarz\ACL\Interfaces\Services\UserAccessServiceInterface;

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
