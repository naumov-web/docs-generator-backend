<?php

namespace App\Http\Resources\Api\V1\DocumentTemplates;

use App\Http\Resources\Api\BaseApiResource;
use App\Http\Resources\Api\V1\Files\FileResource;
use Illuminate\Http\Request;

/**
 * Class DocumentTemplateResource
 * @package App\Http\Resources\Api\V1\DocumentTemplates
 */
final class DocumentTemplateResource extends BaseApiResource
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
            'created_at' => $this->created_at,
            'file' => $this->whenLoaded('file', function(){
                return new FileResource($this->file);
            })
        ];
    }
}
