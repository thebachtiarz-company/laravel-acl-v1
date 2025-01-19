<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use TheBachtiarz\ACL\Filament\AccessControlList;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\UserAccessResource\Pages;
use TheBachtiarz\ACL\Helpers\Models\AccessManagerModelHelper;
use TheBachtiarz\ACL\Helpers\Models\SourceAccessModelHelper;
use TheBachtiarz\ACL\Helpers\Models\UserModelHelper;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
use TheBachtiarz\ACL\Models\UserAccess;

class UserAccessResource extends Resource
{
    protected static ?string $model = UserAccess::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $cluster = AccessControlList::class;

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Select::make(UserAccessInterface::ATTRIBUTE_USER_ID)->label('User')->inlineLabel()
                        ->prefixIcon('heroicon-m-link')
                        ->required()
                        ->native(false)
                        ->options(UserModelHelper::getListOption())
                        ->searchable()
                        ->disabledOn('edit')->dehydrated()
                        ->columnSpanFull(),
                    Forms\Components\Select::make(UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID)->label('Source')->inlineLabel()
                        ->prefixIcon('heroicon-m-link')
                        ->required()
                        ->native(false)
                        ->options(SourceAccessModelHelper::getListOption())
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(fn(Forms\Set $set) => $set(UserAccessInterface::ATTRIBUTE_ACCESS_MANAGER_ID, null))
                        ->disabledOn('edit')->dehydrated()
                        ->columnSpanFull(),
                    Forms\Components\Select::make(UserAccessInterface::ATTRIBUTE_ACCESS_MANAGER_ID)->label('Access')->inlineLabel()
                        ->prefixIcon('heroicon-m-link')
                        ->required()
                        ->native(false)
                        ->options(fn(Forms\Get $get): array => $get(UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID)
                            ? AccessManagerModelHelper::getListOptionBySourceId($get(UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID))
                            : [])
                        ->searchable()
                        ->disabledOn('edit')->dehydrated()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(UserAccessInterface::ATTRIBUTE_GRANTED_BY)->label('Granted By')->inlineLabel()
                        ->prefixIcon('heroicon-m-user')
                        ->disabledOn('edit')
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                ])->columns(12)->columnStart(['sm' => 'full', 'md' => 2])->columnSpan(['sm' => 'full', 'md' => 10]),
            ])->columns(12)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->defaultGroup(
                Tables\Grouping\Group::make(UserAccessInterface::ATTRIBUTE_USER_ID)->label('User')
                    ->getTitleFromRecordUsing(fn(\TheBachtiarz\ACL\Models\UserAccess $model) => $model->user()->get()->first()->getIdentifier()),
            )
            ->columns([
                Tables\Columns\TextColumn::make(sprintf('sourceAccess.%s', SourceAccessInterface::ATTRIBUTE_NAME))
                    ->label('Source')
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(sprintf('accessManager.%s', AccessManagerInterface::ATTRIBUTE_NAME))
                    ->label('Access')
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(UserAccessInterface::ATTRIBUTE_GRANTED_BY)->label('Granted By')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(UserAccessInterface::ATTRIBUTE_CREATED_AT)->label(sprintf('Created (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
                Tables\Columns\TextColumn::make(UserAccessInterface::ATTRIBUTE_UPDATED_AT)->label(sprintf('Updated (%s)', config('app.timezone')))
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
            ->emptyStateDescription('Create new User Access to start');
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
            'index' => Pages\ListUserAccesses::route('/'),
            'create' => Pages\CreateUserAccess::route('/create'),
            'edit' => Pages\EditUserAccess::route('/{record}/edit'),
        ];
    }
}
