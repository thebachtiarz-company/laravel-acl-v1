<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources;

use App\Libraries\MyACL\Filament\AccessControlList;
use App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource\Pages;
use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Models\SourceAccess;
use Awcodes\TableRepeater;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class SourceAccessResource extends Resource
{
    protected static ?string $model = SourceAccess::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $cluster = AccessControlList::class;

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make(SourceAccessInterface::ATTRIBUTE_CODE)->label('Code')->inlineLabel()
                        ->prefixIcon('heroicon-m-key')
                        ->required()
                        ->disabledOn('edit')->dehydrated()
                        ->visibleOn('edit')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(SourceAccessInterface::ATTRIBUTE_NAME)->label('Name')->inlineLabel()
                        ->prefixIcon('heroicon-m-document-text')
                        ->required()->string()
                        ->columnSpanFull(),
                    TableRepeater\Components\TableRepeater::make(SourceAccessInterface::ATTRIBUTE_ACCESS)->label('Access')
                        ->headers([
                            TableRepeater\Header::make('name')->label('Name'),
                            TableRepeater\Header::make('access')->label('Access'),
                        ])
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->helperText(fn(mixed $state = null) => new HtmlString($state
                                    ? sprintf('=> %s', Str::camel($state))
                                    : 'Make sure the name is not duplicated with other source.'))
                                ->live(onBlur: true)
                                ->rules(['required', 'string']),
                            TableRepeater\Components\TableRepeater::make(SourceAccessInterface::ATTRIBUTE_ACCESS)->label('Access')
                                ->headers([
                                    TableRepeater\Header::make('access')->label('Access'),
                                ])
                                ->schema([
                                    Forms\Components\TextInput::make('access')
                                        ->rules(['required', 'string']),
                                ])
                                ->default([['access' => 'create'], ['access' => 'read'], ['access' => 'update'], ['access' => 'delete']])
                                ->helperText(new HtmlString(sprintf('Each of access should be in <b>%s</b> format.', 'camelCase')))
                                ->renderHeader(false)
                                ->cloneable(false)
                                ->reorderable(false)
                                ->addActionLabel('Add Access')
                                ->streamlined(),
                        ])
                        ->cloneable(false)
                        ->reorderable(false)
                        ->addActionLabel('Add Role')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make(SourceAccessInterface::ATTRIBUTE_CREATED_BY)->label('Created By')->inlineLabel()
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
            ->columns([
                Tables\Columns\TextColumn::make(SourceAccessInterface::ATTRIBUTE_CODE)->label('Code')
                    ->searchable(isIndividual: true)
                    ->copyable()
                    ->fontFamily(FontFamily::Mono)
                    ->weight(FontWeight::SemiBold),
                Tables\Columns\TextColumn::make(SourceAccessInterface::ATTRIBUTE_NAME)->label('Name')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(SourceAccessInterface::ATTRIBUTE_CREATED_BY)->label('Created By')
                    ->searchable(isIndividual: true)
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make(SourceAccessInterface::ATTRIBUTE_CREATED_AT)->label(sprintf('Created (%s)', config('app.timezone')))
                    ->fontFamily(FontFamily::Mono)
                    ->dateTime(timezone: config('app.timezone')),
                Tables\Columns\TextColumn::make(SourceAccessInterface::ATTRIBUTE_UPDATED_AT)->label(sprintf('Updated (%s)', config('app.timezone')))
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
            ->emptyStateDescription('Create new Source to start');
    }

    public static function getRelations(): array
    {
        return [
            \App\Libraries\MyACL\Filament\AccessControlList\Resources\SourceAccessResource\RelationManagers\AccessManagersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSourceAccesses::route('/'),
            'create' => Pages\CreateSourceAccess::route('/create'),
            'edit' => Pages\EditSourceAccess::route('/{record}/edit'),
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
