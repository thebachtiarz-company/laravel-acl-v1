<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TheBachtiarz\ACL\DTO\Services\SourceAccessMutationInputDTO;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\SourceAccessResource;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Services\SourceAccessServiceInterface;

class CreateSourceAccess extends CreateRecord
{
    protected static string $resource = SourceAccessResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $access = [];

        foreach ($data[SourceAccessInterface::ATTRIBUTE_ACCESS] as $key => $acc) {
            $access[Str::camel(Str::headline($acc['name']))] = collect($acc['access'])
                ->pluck('access')
                ->map(fn(string $value) => Str::camel(Str::headline($value)))
                ->toArray();
        }

        $data[SourceAccessInterface::ATTRIBUTE_ACCESS] = $access;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $process = app(SourceAccessServiceInterface::class)->createOrUpdate(new SourceAccessMutationInputDTO(
            name: $data[SourceAccessInterface::ATTRIBUTE_NAME],
            access: $data[SourceAccessInterface::ATTRIBUTE_ACCESS],
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
