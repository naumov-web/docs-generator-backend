<?php

declare(strict_types=1);

namespace App\Http\Request\Api\V1\Users;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\User;
use App\Rules\EmailNotExists;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UpdateUserRequest
 * @package App\Http\Request\Api\V1\Users
 *
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 * @property string $first_name
 * @property string $surname
 * @property string $last_name
 */
final class UpdateUserRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return [
            'email' => [
                'required',
                'string',
                'email',
                new EmailNotExists($user->id)
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
            ],
            'password_confirmation' => [
                'required_with:password',
                'string',
            ],
            'first_name' => [
                'nullable',
                'string'
            ],
            'surname' => [
                'nullable',
                'string'
            ],
            'last_name' => [
                'nullable',
                'string'
            ],
        ];
    }
}
