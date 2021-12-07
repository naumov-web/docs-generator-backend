<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\BaseApiRequest;
use App\Rules\EmailNotExists;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Api\V1\Auth
 */
final class RegisterRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                new EmailNotExists()
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
            ],
            'company_name' => [
                'nullable',
                'string'
            ]
        ];
    }
}
