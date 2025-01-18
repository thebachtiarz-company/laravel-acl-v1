<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessManagerResource\Components;

use App\Libraries\MyACL\Filament\AccessControlList\Helpers\FormStateHelper;
use App\Libraries\MyACL\Helpers\Models\AccessManagerModelHelper;
use App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;
use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface;
use Filament\Forms;
use Illuminate\Support\Str;

class AccessManagerComponent
{
    public static string $abilities = 'aclAbilitiesForm';
    public static string $aclEntity = 'aclEntity';
    public static string $needCustomAcl = 'needCustomAcl';

    // ? Public Methods

    /**
     * Access form panel
     *
     * @return Forms\Components\Group
     */
    public static function panel(): Forms\Components\Group
    {
        return Forms\Components\Group::make(function (Forms\Components\Group $component, Forms\Get $get): array {
            $sourceSelected = $get(AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID);

            $sources = [];

            foreach (app(SourceAccessRepositoryInterface::class)->collection()->all() as $cKey => $configSource) {
                $sources[] = static::formAccess($configSource)->visible(intval($sourceSelected) === $configSource->getId());
            }

            $component->schema([
                Forms\Components\Section::make('Abilities')->statePath(static::$abilities)->schema($sources)->columnSpanFull(),
            ]);

            return $component->getChildComponents();
        })->columns(12)->columnSpanFull();
    }

    /**
     * Access form component
     *
     * @param string $sourceCode
     * @return Forms\Components\Section
     */
    public static function formComponent(string $sourceCode): Forms\Components\Section
    {
        $source = app(SourceAccessRepositoryInterface::class)->findByCode($sourceCode);

        return Forms\Components\Section::make('Abilities')->schema(function (Forms\Components\Section $component, Forms\Get $get) use ($source): array {
            $component->schema([
                Forms\Components\Select::make(static::$aclEntity)->label('Access Source')->inlineLabel()
                    ->prefixIcon('heroicon-m-link')
                    ->native(false)
                    ->options(AccessManagerModelHelper::getBySource($source)->pluck(
                        AccessManagerInterface::ATTRIBUTE_NAME,
                        AccessManagerInterface::ATTRIBUTE_CODE,
                    )->all())
                    ->live()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) use ($component, $source): void {
                        $code = $get(static::$aclEntity);

                        if ($code) {
                            $entity = AccessManagerModelHelper::findByCode($code);

                            if ($entity) {
                                $set(sprintf('../%s', static::$abilities), FormStateHelper::merge($component, static::decode([
                                    AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID => $source->getId(),
                                    AccessManagerInterface::ATTRIBUTE_ACCESS => $entity->getAccess(),
                                ])));
                            }
                        }
                    })
                    ->columnSpanFull(),
                Forms\Components\Toggle::make(static::$needCustomAcl)->label('Need Custom Access?')->inlineLabel()
                    ->live()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make(AccessManagerInterface::ATTRIBUTE_NAME)->label('Name')->inlineLabel()
                    ->prefixIcon('heroicon-m-document-text')
                    ->visible(fn(Forms\Get $get) => $get(static::$needCustomAcl))
                    ->columnSpanFull(),
                static::formAccess($source)->disabled(fn(Forms\Get $get) => !$get(static::$needCustomAcl)),
            ]);

            return $component->getChildComponents();
        })->statePath(static::$abilities)->columnSpanFull();
    }

    /**
     * Generate Access from accessor
     *
     * @param string $sourceCode
     * @param array $data
     * @return void
     */
    public static function generateFromAccessor(string $sourceCode, array &$data = []): void
    {
        if ($data[static::$needCustomAcl]) {
            $source = app(SourceAccessRepositoryInterface::class)->findByCode($sourceCode);
            $data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID] = $source;
            $data[static::$abilities] = $data;

            // $process = app(AclManagerServiceInterface::class)->createOrUpdate(new AclManagerMutationInputDTO(
            //     source: $source,
            //     name: $data[AccessManagerInterface::ATTRIBUTE_NAME],
            //     access: static::encode($data),
            // ));

            // $data[static::$aclEntity] = $process->model->getCode();
        }
    }

    /**
     * Encode abilities into system readable
     *
     * @param array $data
     * @return array<int,string>
     */
    public static function encode(array $data): array
    {
        $sourceSelected = app(SourceAccessRepositoryInterface::class)->getByPrimaryKey($data[AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID]);
        assert($sourceSelected instanceof SourceAccessInterface);

        $filteredAbilities = [];

        foreach ($sourceSelected->getAccess() ?? [] as $header => $mutators) {
            $filteredAbilities[$header] = $data[static::$abilities][$header];
        }

        $encodedAbilities = [];

        foreach ($filteredAbilities as $header => $mutator) {
            foreach ($mutator as $key => $access) {
                $encodedAbilities[] = sprintf('%s:%s', $header, $access);
            }
        }

        return $encodedAbilities;
    }

    /**
     * Decode abilities into human readable
     *
     * @param array $data
     * @return array<string,array<int,string>>
     */
    public static function decode(array $data): array
    {
        $decodedAbilities = [];

        foreach ($data[AccessManagerInterface::ATTRIBUTE_ACCESS] as $key => $accessMutator) {
            [$access, $mutator] = explode(separator: ':', string: $accessMutator);

            $decodedAbilities[$access][] = $mutator;
        }

        return $decodedAbilities;
    }

    // ? Protected Methods

    /**
     * Generate form access
     *
     * @param SourceAccessInterface $source
     * @return Forms\Components\Group
     */
    protected static function formAccess(SourceAccessInterface $source): Forms\Components\Group
    {
        $abilities = [];

        foreach ($source->getAccess() ?? [] as $header => $mutators) {
            $options = [];

            foreach ($mutators as $key => $mutator) {
                $options[$mutator] = Str::headline($mutator);
            }

            $abilities[] = Forms\Components\Fieldset::make(Str::headline($header))->schema([
                Forms\Components\CheckboxList::make($header)->hiddenLabel()
                    ->options($options)
                    ->bulkToggleable()
                    ->columns(6)
                    ->live()
                    ->columnSpanFull(),
            ])->columnSpanFull();
        }

        return Forms\Components\Group::make($abilities)->columns(12)->columnSpanFull();
    }
}
