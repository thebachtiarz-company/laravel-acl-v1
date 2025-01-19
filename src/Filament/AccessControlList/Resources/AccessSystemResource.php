<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TheBachtiarz\ACL\Filament\AccessControlList;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource\Components\AccessSystemComponent;
use TheBachtiarz\ACL\Filament\AccessControlList\Resources\AccessSystemResource\Pages;
use TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;
use TheBachtiarz\ACL\Models\AccessSystem;

class AccessSystemResource extends Resource
{
    protected static ?string $model = AccessSystem::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $cluster = AccessControlList::class;

    protected static ?int $navigationSort = 40;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make(AccessSystemInterface::ATTRIBUTE_CODE)->label('Code')->inlineLabel()
                        ->prefixIcon('heroicon-m-key')
                        ->required()
                        ->disabledOn('edit')->dehydrated()
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(AccessSystemInterface::ATTRIBUTE_ADDRESS)->label('Address')->inlineLabel()
                        ->prefixIcon('heroicon-m-link')
                        ->helperText('Set with method address.')
                        ->required()
                        ->disabledOn('edit')->dehydrated()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(AccessSystemInterface::ATTRIBUTE_NAME)->label('Name')->inlineLabel()
                        ->prefixIcon('heroicon-m-document-text')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make(AccessSystemInterface::ATTRIBUTE_DESCRIPTION)->label('Description')->inlineLabel()
                        ->helperText('Describe the access purpose in this method.')
                        ->columnSpanFull(),
                    AccessSystemComponent::panel(),
                ])->columns(12)->columnStart(['sm' => 'full', 'md' => 2])->columnSpan(['sm' => 'full', 'md' => 10]),
            ])->columns(12)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make(AccessSystemInterface::ATTRIBUTE_CODE)->label('Code')
                    ->searchable(isIndividual: true)
                    ->copyable()
                    ->fontFamily(FontFamily::Mono)
                    ->weight(FontWeight::SemiBold),
                Tables\Columns\TextColumn::make(AccessSystemInterface::ATTRIBUTE_NAME)->label('Name')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(AccessSystemInterface::ATTRIBUTE_CREATED_BY)->label('Created By')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(AccessSystemInterface::ATTRIBUTE_CREATED_AT)->label(sprintf('Created (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
                Tables\Columns\TextColumn::make(AccessSystemInterface::ATTRIBUTE_UPDATED_AT)->label(sprintf('Updated (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->actionsColumnLabel('Actions')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->searchable(false)
            ->emptyStateHeading('No Data')
            ->emptyStateDescription('Create new Access System to start');
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
            'index' => Pages\ListAccessSystems::route('/'),
            'create' => Pages\CreateAccessSystem::route('/create'),
            'edit' => Pages\EditAccessSystem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
