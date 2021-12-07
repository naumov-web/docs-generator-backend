<?php

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
