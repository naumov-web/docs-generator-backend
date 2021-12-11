<?php

namespace App\Http\Resources\Api\V1\Users;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class UserDetailResource
 * @package App\Http\Resources\Api\V1\Users
 */
final class UserDetailResource extends BaseApiResource
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
            'email' => $this->email,
            'first_name' => $this->first_name,
            'surname' => $this->surname,
            'last_name' => $this->last_name,
        ];
    }
}
