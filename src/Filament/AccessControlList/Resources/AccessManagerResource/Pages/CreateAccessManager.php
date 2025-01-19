<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\DTO\Services\AccessManagerMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Components\AccessManagerComponent;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Services\AccessManagerServiceInterface;

class CreateAccessManager extends CreateRecord
{
    protected static string $resource = AccessManagerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data[AccessManagerInterface::ATTRIBUTE_ACCESS] = AccessManagerComponent::encode($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $process = app(AccessManagerServiceInterface::class)->createOrUpdate(new AccessManagerMutationInputDTO(
            sourceId: $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID],
            name: $data[AccessManagerInterface::ATTRIBUTE_NAME],
            access: $data[AccessManagerInterface::ATTRIBUTE_ACCESS],
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
