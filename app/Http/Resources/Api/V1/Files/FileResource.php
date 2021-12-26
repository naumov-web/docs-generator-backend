<?php

namespace App\Http\Resources\Api\V1\Files;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class FileResource
 * @package App\Http\Resources\Api\V1\Files
 */
final class FileResource extends BaseApiResource
{
    /**
     * Convert object to array
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mime' => $this->mime,
            'url' => $this->url,
        ];
    }
}
