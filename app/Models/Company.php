<?php

namespace App\Models;

use App\Models\Contracts\IOwner;
use App\Models\Traits\Owner;

/**
 * Class Company
 * @package App\Models
 *
 * @property-read int $id
 * @property string $name
 */
final class Company extends BaseModel implements IOwner
{
    use Owner;
}
