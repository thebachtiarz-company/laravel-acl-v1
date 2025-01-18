<?php

namespace App\Libraries\MyACL\Filament;

class AccessControlList extends \Filament\Clusters\Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Access Control List';

    protected static ?string $clusterBreadcrumb = 'Access Control List';
}
