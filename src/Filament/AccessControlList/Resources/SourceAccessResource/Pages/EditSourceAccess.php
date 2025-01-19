<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TheBachtiarz\ACL\DTO\Services\SourceAccessMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Services\SourceAccessServiceInterface;

class EditSourceAccess extends EditRecord
{
    protected static string $resource = SourceAccessResource::class;

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
        $access = [];

        foreach ($data[SourceAccessInterface::ATTRIBUTE_ACCESS] as $name => $acc) {
            $access[] = [
                'name' => Str::headline($name),
                'access' => collect($acc)->map(fn(string $value): array => ['access' => $value])->toArray(),
            ];
        }

        $data[SourceAccessInterface::ATTRIBUTE_ACCESS] = $access;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $access = [];

        foreach ($data[SourceAccessInterface::ATTRIBUTE_ACCESS] as $key => $acc) {
            $access[Str::camel(Str::headline($acc['name']))] = collect($acc['access'])
                ->pluck('access')
                ->map(fn(string $value): string => Str::camel(Str::headline($value)))
                ->toArray();
        }

        $data[SourceAccessInterface::ATTRIBUTE_ACCESS] = $access;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $process = app(SourceAccessServiceInterface::class)->createOrUpdate(new SourceAccessMutationInputDTO(
            name: $data[SourceAccessInterface::ATTRIBUTE_NAME],
            access: $data[SourceAccessInterface::ATTRIBUTE_ACCESS],
            code: $data[SourceAccessInterface::ATTRIBUTE_CODE],
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
