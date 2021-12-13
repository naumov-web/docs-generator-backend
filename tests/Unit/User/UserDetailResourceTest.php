<?php

namespace Tests\Unit\User;

use App\Http\Resources\Api\V1\Users\UserDetailResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Tests\BaseTest;

/**
 * Class UserDetailResourceTest
 * @package Tests\Unit\Users
 */
final class UserDetailResourceTest extends BaseTest
{
    /**
     * Test case, when email already exists
     * Test case reproduce:
     * 1. Define user data
     * 2. Create user instance
     * 3. Create resource instance, call toArray method and check result of method calling
     *
     * Expected result: Method returns all fields of user instance except password
     *
     * @test
     * @return void
     */
    public function testToArrayMethod(): void
    {
        // 1. Define user data
        $data = [
            'email' => 'user1@mail.com',
            'password' => 'password',
            'first_name' => 'First name',
            'surname' => 'Surname',
            'last_name' => 'Last name',
        ];

        // 2. Create user instance
        /**
         * @var User $user
         */
        $user = User::query()->create($data);

        // 3. Create resource instance, call toArray method and check result of method calling
        $resource = new UserDetailResource($user);

        $this->assertEquals(
            Arr::only(
                $user->toArray(),
                [
                    'id',
                    'email',
                    'first_name',
                    'surname',
                    'last_name'
                ]
            ),
            $resource->toArray(new Request())
        );
    }
}
