<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;

use App\Libraries\MyACL\DTO\Services\AccessManagerMutationInputDTO;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource\Components\AccessManagerComponent;
use App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;
use App\Libraries\MyACL\Interfaces\Services\AccessManagerServiceInterface;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

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
