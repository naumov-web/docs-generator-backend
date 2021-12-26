<?php

namespace App\Models;

/**
 * Class File
 * @package App\Models
 *
 * @property-read int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $name
 * @property string $mime
 * @property string $path
 *
 * @property string $full_path
 */
final class File extends BaseModel
{
    /**
     * Path to directory for uploading of file
     *
     * @var string
     */
    public const UPLOAD_DIR_PATH = '/storage/app/public';

    /**
     * Path template for uploading of file
     *
     * @var string
     */
    public const PATH_TEMPLATE = '/uploads/{{date}}/{{uid}}/{{file_name}}';

    /**
     * Get full path attribute accessor
     *
     * @return string
     */
    public function getFullPathAttribute(): string
    {
        return base_path(self::UPLOAD_DIR_PATH . $this->path);
    }

    /**
     * Get URL attribute accessor
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return config('app.url') . '/storage' . $this->path;
    }
}
