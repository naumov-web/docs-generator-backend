<?php

namespace App\Http\Requests\Api\V1\DocumentTemplates;

use App\Http\Requests\Api\BaseListRequest;

/**
 * Class GetDocumentTemplatesRequest
 * @package App\Http\Requests\Api\V1\DocumentTemplates
 */
final class GetDocumentTemplatesRequest extends BaseListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $sortable_columns = [
            'id',
            'name',
            'created_at',
        ];

        return $this->composeListRules($sortable_columns);
    }
}
