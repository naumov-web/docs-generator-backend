<?php

namespace App\Http\Requests\Api\V1\DocumentTemplates;

use App\Accessors\DefaultAccessor;
use App\Http\Requests\Api\BaseApiRequest;
use App\Models\DocumentTemplate;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class DeleteDocumentTemplateRequest
 * @package App\Http\Requests\Api\V1\DocumentTemplates
 */
final class DeleteDocumentTemplateRequest extends BaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws BindingResolutionException
     */
    public function authorize(): bool
    {
        /**
         * @var DefaultAccessor $accessor
         */
        $accessor = app()->make(DefaultAccessor::class);
        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = $this->route('document_template');
        /**
         * @var User $user
         */
        $user = auth()->user();
        $owner = $user->first_company ?? $user;

        return $accessor->checkAccess($document_template, $owner);
    }

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
