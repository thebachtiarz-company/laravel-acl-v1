<?php

namespace TheBachtiarz\ACL\Filament\AccessControlList\Helpers;

use Filament\Forms\Components\Component;

class FormStateHelper
{
    /**
     * Add state into component
     *
     * @param Component $component
     * @param array $states Default []
     * @param boolean $useRecursive Default false
     * @return array
     */
    public static function merge(Component $component, array $states = [], bool $useRecursive = false): array
    {
        return $useRecursive
            ? array_merge_recursive($component->getState(), $states)
            : array_merge($component->getState(), $states);
    }
}
