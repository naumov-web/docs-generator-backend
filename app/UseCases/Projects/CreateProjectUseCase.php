<?php

declare(strict_types=1);

namespace App\UseCases\Projects;

use App\DTO\Input\Projects\CreateProjectDTO;
use App\Models\Project;
use App\Repositories\ProjectsRepository;
use App\UseCases\BaseUseCase;
use Illuminate\Support\Str;

/**
 * Class CreateProjectUseCase
 * @package App\UseCases\Projects
 */
final class CreateProjectUseCase extends BaseUseCase
{
    /**
     * Projects repository instance
     * @var ProjectsRepository
     */
    private ProjectsRepository $repository;

    /**
     * Projects config
     * @var array
     */
    private array $config;

    /**
     * Project instance
     * @var Project
     */
    private Project $project;

    /**
     * CreateProjectUseCase constructor
     * @param ProjectsRepository $repository
     */
    public function __construct(ProjectsRepository $repository)
    {
        $this->repository = $repository;
        $this->config = config('projects');
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateProjectDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $data = [
            'name' => $this->input_dto->getName(),
            'system_name' => $this->input_dto->getSystemName(),
            'access_key' => Str::random($this->config['access_key_length']),
            'user_owner_id' => $this->input_dto->getUser()->id
        ];

        /**
         * @var Project $new_project
         */
        $new_project = $this->repository->store($data);
        $this->project = $new_project;
    }

    /**
     * Get project instance
     *
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }
}
