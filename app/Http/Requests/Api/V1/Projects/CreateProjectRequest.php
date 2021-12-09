<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Projects;

use App\Http\Requests\Api\BaseApiRequest;
use App\Rules\ProjectSystemNameExists;

/**
 * Class CreateProjectRequest
 * @package App\Http\Requests\Api\V1\Projects;
 *
 * @property string $system_name
 * @property string $name
 */
final class CreateProjectRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'system_name' => [
                'required',
                'string',
                new ProjectSystemNameExists()
            ],
            'name' => [
                'required',
                'string'
            ]
        ];
    }
}
