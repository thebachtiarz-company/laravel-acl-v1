<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource\Pages;

use App\Libraries\MyACL\DTO\Services\AccessSystemMutationInputDTO;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource\Components\AccessSystemComponent;
use App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
use App\Libraries\MyACL\Interfaces\Services\AccessSystemServiceInterface;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

class CreateAccessSystem extends CreateRecord
{
    protected static string $resource = AccessSystemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data[AccessSystemInterface::ATTRIBUTE_ACCESS] = AccessSystemComponent::encode($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $process = app(AccessSystemServiceInterface::class)->createOrUpdate(new AccessSystemMutationInputDTO(
            address: $data[AccessSystemInterface::ATTRIBUTE_ADDRESS],
            name: $data[AccessSystemInterface::ATTRIBUTE_NAME],
            access: $data[AccessSystemInterface::ATTRIBUTE_ACCESS],
            description: $data[AccessSystemInterface::ATTRIBUTE_DESCRIPTION],
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
