<?php

namespace Tests\Feature\V1\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tests\Feature\BaseFeatureTest;

/**
 * Class RegisterValidationTest
 * @package Tests\Feature\V1\Auth
 */
final class RegisterValidationTest extends BaseFeatureTest
{
    /**
     * Route name for testing
     * @var string
     */
    public const ROUTE_NAME = 'v1.auth.register';

    /**
     * Test case, when email already exists
     * Test case reproduce:
     * 1. Seed database
     * 2. Define input data
     * 3. Create user manually into database with email from input data
     * 4. Execute request to API and check response code
     *
     * Expected result: API returns error with code 422
     *
     * @test
     * @return void
     */
    public function testEmailAlreadyExists(): void
    {
        // 1. Seed database
        $this->seedDatabase();

        // 2. Define input data
        $data = [
            'email' => 'email1@email.com',
            'password' => 'qweasd',
            'password_confirmation' => 'qweasd'
        ];

        // 3. Create user manually into database with email from input data
        User::query()->create(
            Arr::only(
                $data,
                ['email', 'password']
            )
        );

        // 4. Execute request to API and check response code
        $this->json(
            $method = 'POST',
            route(self::ROUTE_NAME),
            $data
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
