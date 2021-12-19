<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Common\FileDTO;
use App\Models\File;
use App\Repositories\FilesRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FilesService
 * @package App\Services
 */
final class FilesService extends BaseEntityService
{
    /**
     * Files repository instance
     * @var FilesRepository
     */
    private FilesRepository $repository;

    /**
     * FilesService constructor.
     * @param FilesRepository $repository
     */
    public function __construct(FilesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create file
     *
     * @param Model $owner
     * @param FileDTO $data
     * @return File
     */
    public function create(Model $owner, FileDTO $data): File
    {
        // 1. Prepare paths
        $uniqid = uniqid();
        $dir_path = str_replace(
            ['{{date}}', '{{uid}}', '{{file_name}}'],
            [date('Y-m-d'), $uniqid, ''],
            File::PATH_TEMPLATE
        );
        $full_dir_path = base_path(File::UPLOAD_DIR_PATH . $dir_path);
        $file_path = str_replace(
            ['{{date}}', '{{uid}}', '{{file_name}}'],
            [date('Y-m-d'), $uniqid, $data->getName()],
            File::PATH_TEMPLATE
        );
        $full_file_path = base_path(File::UPLOAD_DIR_PATH . $file_path);

        // 2. Create directory if not exists
        if (!file_exists($full_dir_path)) {
            mkdir($full_dir_path, 0777, $recursive = true);
        }

        // 3. Store file
        file_put_contents($full_file_path, base64_decode($data->getContent()));

        // 4. Store model
        $model_data = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'name' => $data->getName(),
            'mime' => $data->getMime(),
            'path' => $file_path,
        ];

        /**
         * @var File $result
         */
        $result = $this->repository->store($model_data);

        return $result;
    }
}
