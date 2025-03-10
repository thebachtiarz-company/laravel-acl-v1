<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\DTO\Services\AccessSystemMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource\Components\AccessSystemComponent;
use TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;
use TheBachtiarz\ACL\Interfaces\Services\AccessSystemServiceInterface;

class EditAccessSystem extends EditRecord
{
    protected static string $resource = AccessSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Delete')->icon('heroicon-s-trash'),
            Actions\ForceDeleteAction::make()->label('Trash')->icon('heroicon-s-trash'),
            Actions\RestoreAction::make()->label('Restore')->icon('heroicon-s-arrow-uturn-left'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data[AccessSystemComponent::$abilities] = AccessSystemComponent::decode($data);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data[AccessSystemInterface::ATTRIBUTE_ACCESS] = AccessSystemComponent::encode($data);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $process = app(AccessSystemServiceInterface::class)->createOrUpdate(new AccessSystemMutationInputDTO(
            address: $data[AccessSystemInterface::ATTRIBUTE_ADDRESS],
            name: $data[AccessSystemInterface::ATTRIBUTE_NAME],
            access: $data[AccessSystemInterface::ATTRIBUTE_ACCESS],
            description: $data[AccessSystemInterface::ATTRIBUTE_DESCRIPTION],
            code: $data[AccessSystemInterface::ATTRIBUTE_CODE],
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
