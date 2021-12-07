<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Testing\TestResponse;
use Tests\BaseTest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class BaseFeatureTest
 * @package Tests\Feature
 */
abstract class BaseFeatureTest extends BaseTest
{
    /**
     * Signed user instance
     * @var User|null
     */
    protected ?User $signed_user = null;

    /**
     * Predefine before tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }

    /**
     * Execute json request
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = []) : TestResponse
    {
        if ($this->signed_user) {
            $headers = array_merge([
                'Authorization' => $this->getAuthorizationHeaderValue(),
            ], $headers);
        }

        return parent::json($method, $uri, $data, $headers);
    }

    /**
     * Get authorization header value
     *
     * @return string|null
     */
    protected function getAuthorizationHeaderValue(): ?string
    {
        if ($this->signed_user) {
            $base64 = JWTAuth::fromUser($this->signed_user);

            return 'Bearer ' . $base64;
        }

        return null;
    }
}
