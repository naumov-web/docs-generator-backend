<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Common\FileDTO;
use App\DTO\Input\DocumentTemplates\CreateDocumentTemplateDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\DocumentTemplates\CreateDocumentTemplateRequest;
use App\Models\User;
use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class DocumentTemplatesController
 * @package App\Http\Controllers\Api\V1
 */
final class DocumentTemplatesController extends BaseApiController
{
    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    private UseCaseFactory $use_case_factory;

    /**
     * AuthController constructor
     * @param UseCaseFactory $use_case_factory
     */
    public function __construct(UseCaseFactory $use_case_factory)
    {
        $this->use_case_factory = $use_case_factory;
    }

    /**
     * Create new document template
     *
     * @param CreateDocumentTemplateRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    public function create(CreateDocumentTemplateRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = auth()->user();
        $input_dto = new CreateDocumentTemplateDTO(
            $request->name,
            new FileDTO(
                $request->file['name'],
                $request->file['mime'],
                $request->file['content']
            ),
            $user
        );
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::CREATE_DOCUMENT_TEMPLATE);
        $use_case->setInputDTO($input_dto);
        $use_case->execute();

        return response()->json([
            'success' => true,
            'message' => __('messages.document_template_successfully_created')
        ]);
    }
}
