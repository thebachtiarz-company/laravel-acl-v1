<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\DTO\Services\AccessManagerMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Components\AccessManagerComponent;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Services\AccessManagerServiceInterface;

class EditAccessManager extends EditRecord
{
    protected static string $resource = AccessManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Delete')->icon('heroicon-s-trash'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data[AccessManagerComponent::$abilities] = AccessManagerComponent::decode($data);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data[AccessManagerInterface::ATTRIBUTE_ACCESS] = AccessManagerComponent::encode($data);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $process = app(AccessManagerServiceInterface::class)->createOrUpdate(new AccessManagerMutationInputDTO(
            sourceId: $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID],
            name: $data[AccessManagerInterface::ATTRIBUTE_NAME],
            access: $data[AccessManagerInterface::ATTRIBUTE_ACCESS],
            code: $data[AccessManagerInterface::ATTRIBUTE_CODE],
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
