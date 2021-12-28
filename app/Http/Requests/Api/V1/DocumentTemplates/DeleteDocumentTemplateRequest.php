<?php

namespace App\Http\Requests\Api\V1\DocumentTemplates;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class DeleteDocumentTemplateRequest
 * @package App\Http\Requests\Api\V1\DocumentTemplates
 */
final class DeleteDocumentTemplateRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
