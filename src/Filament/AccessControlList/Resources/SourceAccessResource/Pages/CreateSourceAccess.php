<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;

use App\Libraries\MyACL\DTO\Services\SourceAccessMutationInputDTO;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource;
use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Services\SourceAccessServiceInterface;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
