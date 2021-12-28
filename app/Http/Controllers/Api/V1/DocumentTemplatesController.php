<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Common\FileDTO;
use App\DTO\Input\DocumentTemplates\CreateDocumentTemplateDTO;
use App\DTO\Input\DocumentTemplates\DeleteDocumentTemplateDTO;
use App\DTO\Input\DocumentTemplates\GetDocumentTemplatesDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\DocumentTemplates\CreateDocumentTemplateRequest;
use App\Http\Requests\Api\V1\DocumentTemplates\DeleteDocumentTemplateRequest;
use App\Http\Requests\Api\V1\DocumentTemplates\GetDocumentTemplatesRequest;
use App\Http\Resources\Api\ListResource;
use App\Http\Resources\Api\V1\DocumentTemplates\DocumentTemplateResource;
use App\Models\DocumentTemplate;
use App\Models\User;
use App\UseCases\BaseUseCase;
use App\UseCases\Contracts\IGettingEntities;
use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.document_template_successfully_created')
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Handle request for getting of document templates
     *
     * @param GetDocumentTemplatesRequest $request
     * @return ListResource
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function index(GetDocumentTemplatesRequest $request): ListResource
    {
        /**
         * @var User $user
         */
        $user = auth()->user();
        $input_dto = (new GetDocumentTemplatesDTO($user))
            ->fill(
                $request->only([
                    'limit',
                    'offset',
                    'sort_by',
                    'sort_direction'
                ])
            );
        /**
         * @var IGettingEntities&BaseUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::GET_DOCUMENT_TEMPLATES);
        $use_case->setInputDTO($input_dto);
        $use_case->execute();

        $items_dto = $use_case->getListDTO();

        return new ListResource(
            DocumentTemplateResource::class,
            $items_dto->getModels(),
            $items_dto->getCount()
        );
    }

    /**
     * Handle request for deleting of document template
     *
     * @param DeleteDocumentTemplateRequest $request
     * @param DocumentTemplate $document_template
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function delete(DeleteDocumentTemplateRequest $request, DocumentTemplate $document_template): JsonResponse
    {
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::DELETE_DOCUMENT_TEMPLATE);
        $use_case->setInputDTO(new DeleteDocumentTemplateDTO($document_template));
        $use_case->execute();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.document_template_successfully_deleted')
            ]
        );
    }
}
