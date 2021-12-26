<?php

namespace App\UseCases\DocumentTemplates;

use App\DTO\Common\FilterDTO;
use App\DTO\Common\ListItemsDTO;
use App\DTO\Input\DocumentTemplates\GetDocumentTemplatesDTO;
use App\Repositories\DocumentTemplatesRepository;
use App\UseCases\BaseUseCase;
use App\UseCases\Contracts\IGettingEntities;

/**
 * Class GetDocumentTemplatesUseCase
 * @package App\UseCases\DocumentTemplates
 */
final class GetDocumentTemplatesUseCase extends BaseUseCase implements IGettingEntities
{
    /**
     * Document templates repository instance
     * @var DocumentTemplatesRepository
     */
    private DocumentTemplatesRepository $repository;

    /**
     * List items DTO instance
     * @var ListItemsDTO
     */
    private ListItemsDTO $items_dto;

    /**
     * GetDocumentTemplatesUseCase constructor
     * @param DocumentTemplatesRepository $repository
     */
    public function __construct(DocumentTemplatesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetDocumentTemplatesDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /**
         * @var GetDocumentTemplatesDTO $input_dto
         */
        $input_dto = $this->input_dto;
        $index_dto = $input_dto->getIndexDTO();
        $index_dto->setWith(['file']);
        $user = $input_dto->getUser();

        if ($user->first_company) {
            $index_dto->addFilter(new FilterDTO('owner_id', '=', $user->first_company->id))
                ->addFilter(new FilterDTO('owner_type', '=', get_class($user->first_company)));
        } else {
            $index_dto->addFilter(new FilterDTO('owner_id', '=', $user->id))
                ->addFilter(new FilterDTO('owner_type', '=', get_class($user)));
        }

        $this->items_dto = $this->repository->index($index_dto);
    }

    /**
     * @inheritDoc
     */
    public function getListDTO(): ListItemsDTO
    {
        return $this->items_dto;
    }
}
