<?php

namespace App\UseCases\Auth;

use App\DTO\Input\Auth\LoginDTO;
use App\Exceptions\InvalidCredentialsException;
use App\UseCases\BaseUseCase;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class LoginUseCase
 * @package App\UseCases\Auth
 */
final class LoginUseCase extends BaseUseCase
{
    /**
     * Token prefix
     * @var string
     */
    public const TOKEN_PREFIX = 'Bearer ';

    /**
     * Authorization token value
     * @var string|null
     */
    private string|null $token = null;

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return LoginDTO::class;
    }

    /**
     * @inheritDoc
     * @throws AuthorizationException
     */
    public function execute(): void
    {
        $token = JWTAuth::attempt([
            'email' => $this->input_dto->getEmail(),
            'password' => $this->input_dto->getPassword()
        ]);

        if ($token) {
            $this->token = self::TOKEN_PREFIX . $token;
        } else {
            throw new AuthorizationException();
        }
    }

    /**
     * Get token value
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}
