<?php

use App\Models\User;

/**
 * Get remote username
 *
 * @return string
 */
function get_remote_user_name(): ?string
{
    $default = config('app.default_username');

    if ($default) {
        return $default;
    }

    return $_SERVER['REMOTE_USER'] ?? null;
}

/**
 * Get remote user model
 *
 * @return User|null
 */
function get_remote_user(): ?User
{
    $username = get_remote_user_name();

    /**
     * @var User $user
     */
    $user = User::query()
        ->where('username', strtolower($username))
        ->first();

    return $user;
}
