<?php

namespace App\Libraries\MyACL\Filament;

class ClusterCall extends \TheBachtiarz\Admin\Filament\Settings\FilamentDiscoverClass
{
    public static function dirname(): string
    {
        return dirname(__FILE__);
    }
}
