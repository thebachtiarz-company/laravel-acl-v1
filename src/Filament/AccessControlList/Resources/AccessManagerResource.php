<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use TheBachtiarz\ACL\Filament\AccessControlList;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Components\AccessManagerComponent;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessManagerResource\Pages;
use TheBachtiarz\ACL\Helpers\Models\SourceAccessModelHelper;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Models\AccessManager;

class AccessManagerResource extends Resource
{
    protected static ?string $model = AccessManager::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $cluster = AccessControlList::class;

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make(AccessManagerInterface::ATTRIBUTE_CODE)->label('Code')->inlineLabel()
                        ->prefixIcon('heroicon-m-key')
                        ->required()
                        ->disabledOn('edit')->dehydrated()
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                    Forms\Components\Select::make(AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID)->label('Source')->inlineLabel()
                        ->prefixIcon('heroicon-m-link')
                        ->required()
                        ->native(false)
                        ->options(SourceAccessModelHelper::getListOption())
                        ->disabledOn('edit')->dehydrated()
                        ->live()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(AccessManagerInterface::ATTRIBUTE_NAME)->label('Name')->inlineLabel()
                        ->prefixIcon('heroicon-m-document-text')
                        ->required()
                        ->columnSpanFull(),
                    AccessManagerComponent::panel(),
                ])->columns(12)->columnStart(['sm' => 'full', 'md' => 2])->columnSpan(['sm' => 'full', 'md' => 10]),
            ])->columns(12)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->defaultGroup(
                Tables\Grouping\Group::make(AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID)->label('Source')
                    ->getTitleFromRecordUsing(fn(\TheBachtiarz\ACL\Models\AccessManager $model) => $model->sourceAccess()->get()->first()->getName()),
            )
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
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccessManagers::route('/'),
            'create' => Pages\CreateAccessManager::route('/create'),
            'edit' => Pages\EditAccessManager::route('/{record}/edit'),
        ];
    }
}
