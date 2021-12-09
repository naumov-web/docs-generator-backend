<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\Traits\UseListRules;

/**
 * Class BaseListRequest
 * @package App\Http\Requests\Api
 */
abstract class BaseListRequest extends BaseApiRequest
{
    use UseListRules;
}
