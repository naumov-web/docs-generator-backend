<?php

namespace App\Enums;

/**
 * Class UseCaseSystemNamesEnum
 * @package App\Enums
 */
final class UseCaseSystemNamesEnum
{
    /**
     * Use case "Register"
     * @var string
     */
    public const REGISTER = 'register';

    /**
     * Use case "Login"
     * @var string
     */
    public const LOGIN = 'login';

    /**
     * Use case "Show detail user"
     * @var string
     */
    public const SHOW_DETAIL_USER = 'show_detail_user';

    /**
     * Use case "Update specific user"
     * @var string
     */
    public const UPDATE_SPECIFIC_USER = 'update_specific_user';
}
