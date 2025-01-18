<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource\RelationManagers;

use App\Libraries\MyACL\DTO\Services\AccessManagerMutationInputDTO;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource\Components\AccessManagerComponent;
use App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;
use App\Libraries\MyACL\Interfaces\Services\AccessManagerServiceInterface;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class AccessManagersRelationManager extends RelationManager
{
    protected static string $relationship = 'accessManagers';

    public function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make(AccessManagerInterface::ATTRIBUTE_CODE)->label('Code')
                    ->searchable(isIndividual: true)
                    ->copyable()
                    ->fontFamily(FontFamily::Mono)
                    ->weight(FontWeight::SemiBold),
                Tables\Columns\TextColumn::make(AccessManagerInterface::ATTRIBUTE_NAME)->label('Name')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(AccessManagerInterface::ATTRIBUTE_CREATED_BY)->label('Created By')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(AccessManagerInterface::ATTRIBUTE_CREATED_AT)->label(sprintf('Created (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
                Tables\Columns\TextColumn::make(AccessManagerInterface::ATTRIBUTE_UPDATED_AT)->label(sprintf('Updated (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add New Access Manager')->icon('heroicon-c-plus')
                    ->modalWidth(MaxWidth::SixExtraLarge)
                    ->form(fn(Form $form) => \App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource::form($form))
                    ->fillForm(function () {
                        $data = [];

                        $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID] = $this->getOwnerRecord()->getId();

                        return $data;
                    })
                    ->action(function (Tables\Actions\CreateAction $createAction) {
                        $data = $createAction->getFormData();

                        $data[AccessManagerInterface::ATTRIBUTE_ACCESS] = AccessManagerComponent::encode($data);

                        $process = app(AccessManagerServiceInterface::class)->createOrUpdate(new AccessManagerMutationInputDTO(
                            sourceId: $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID],
                            name: $data[AccessManagerInterface::ATTRIBUTE_NAME],
                            access: $data[AccessManagerInterface::ATTRIBUTE_ACCESS],
                        ));

                        if ($process->condition->toBoolean()) {
                            Notification::make()
                                ->success()
                                ->title($process->message)
                                ->send();
                        } else {
                            Notification::make()
                                ->warning()
                                ->title($process->message)
                                ->send();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth(MaxWidth::SixExtraLarge)
                    ->form(fn(Form $form) => \App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource::form($form))
                    ->fillForm(function (AccessManagerInterface $record) {
                        $data = $record->{'toArray'}();

                        $data[AccessManagerComponent::$abilities] = AccessManagerComponent::decode($data);

                        return $data;
                    })
                    ->action(function (Tables\Actions\EditAction $editAction) {
                        $data = $editAction->getFormData();

                        $data[AccessManagerInterface::ATTRIBUTE_ACCESS] = AccessManagerComponent::encode($data);

                        $process = app(AccessManagerServiceInterface::class)->createOrUpdate(new AccessManagerMutationInputDTO(
                            sourceId: $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID],
                            name: $data[AccessManagerInterface::ATTRIBUTE_NAME],
                            access: $data[AccessManagerInterface::ATTRIBUTE_ACCESS],
                            code: $data[AccessManagerInterface::ATTRIBUTE_CODE],
                        ));

                        if ($process->condition->toBoolean()) {
                            Notification::make()
                                ->success()
                                ->title($process->message)
                                ->send();
                        } else {
                            Notification::make()
                                ->warning()
                                ->title($process->message)
                                ->send();
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->actionsColumnLabel('Actions')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchable(false)
            ->emptyStateHeading('No Data')
            ->emptyStateDescription('Create new Access Manager to start');
    }
}
