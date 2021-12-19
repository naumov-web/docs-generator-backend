<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\DocumentTemplates;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\User;
use App\Rules\DocumentTemplateNotExists;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class CreateDocumentTemplateRequest
 * @package App\Http\Requests\Api\V1\DocumentTemplates
 *
 * @property string $name
 * @property array $file
 */
final class CreateDocumentTemplateRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return [
            'name' => [
                'required',
                'string',
                new DocumentTemplateNotExists($user)
            ],
            'file' => [
                'array',
                'required'
            ],
            'file.name' => [
                'required_with:file',
                'string'
            ],
            'file.mime' => [
                'required_with:file',
                'string'
            ],
            'file.content' => [
                'required_with:file',
                'string'
            ],
        ];
    }
}
