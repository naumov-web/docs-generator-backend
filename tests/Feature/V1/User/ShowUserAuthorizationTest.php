<?php

namespace Tests\Feature\V1\User;

use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tests\Feature\BaseFeatureTest;

/**
 * Class ShowUserAuthorizationTest
 * @package Tests\Feature\V1\User
 */
final class ShowUserAuthorizationTest extends BaseFeatureTest
{
    /**
     * Route name for testing
     * @var string
     */
    public const ROUTE_NAME = 'v1.account.user.show';

    /**
     * Test case, when email already exists
     * Test case reproduce:
     * 1. Seed database
     * 2. Execute request to API without authorization header and check response code
     *
     * Expected result: API returns error with code 401
     *
     * @test
     * @return void
     */
    public function testEmailAlreadyExists(): void
    {
        // 1. Seed database
        $this->seedDatabase();

        // 4. Execute request to API and check response code
        $this->json(
            $method = 'GET',
            route(self::ROUTE_NAME),
        )->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
