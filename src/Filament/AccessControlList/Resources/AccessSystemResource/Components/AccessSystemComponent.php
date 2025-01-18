<?php

namespace App\Libraries\MyACL\Filament\AccessControlList\Resources\AccessSystemResource\Components;

use App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface;
use Filament\Forms;
use Illuminate\Support\Str;

class AccessSystemComponent
{
    public static string $abilities = 'accessSystemForm';
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
            $sources = [];

            foreach (app(SourceAccessRepositoryInterface::class)->collection()->all() as $cKey => $configSource) {
                assert($configSource instanceof SourceAccessInterface);

                $sources[$configSource->getName()][] = static::formAccess($configSource);
            }

            $components = [];

            foreach ($sources as $sourceName => $sourceComponent) {
                $components[] = Forms\Components\Section::make($sourceName)->schema($sourceComponent)->collapsed(false)->columnSpanFull();
            }

            $component->schema([
                Forms\Components\Section::make('Access Area')
                    ->description('Any checked option indicates that accessor must have access permission for that option.')
                    ->statePath(static::$abilities)
                    ->schema($components)
                    ->columnSpanFull(),
            ]);

            return $component->getChildComponents();
        })->columns(12)->columnSpanFull();
    }

    /**
     * Encode abilities into system readable
     *
     * @param array $data
     * @return array<int,string>
     */
    public static function encode(array $data): array
    {
        $filteredAbilities = [];

        foreach (app(SourceAccessRepositoryInterface::class)->collection()->all() as $key => $source) {
            assert($source instanceof SourceAccessInterface);

            foreach ($source->getAccess() ?? [] as $header => $mutators) {
                $filteredAbilities[$header] = $data[static::$abilities][$header];
            }
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

        foreach ($data[AccessSystemInterface::ATTRIBUTE_ACCESS] as $key => $accessMutator) {
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
