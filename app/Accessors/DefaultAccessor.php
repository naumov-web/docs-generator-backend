<?php

namespace App\Accessors;

use App\Models\Contracts\IHasOwner;
use App\Models\Contracts\IOwner;

/**
 * Class DefaultAccessor
 * @package App\Accessors
 */
final class DefaultAccessor
{
    /**
     * Check access to accessible for owner
     *
     * @param IHasOwner $accessible
     * @param IOwner $owner
     * @return bool
     */
    public function checkAccess(IHasOwner $accessible, IOwner $owner): bool
    {
        return ($accessible->getOwnerId() === $owner->getId()) &&
            ($accessible->getOwnerType() === $owner->getType());
    }
}
