<?php

namespace Tests\Unit;

use Tests\BaseTest;
use Tests\Traits\UseUserRegistration;

/**
 * Class BaseUseCaseTest
 * @package Tests\Unit;
 */
abstract class BaseUseCaseTest extends BaseTest
{
    use UseUserRegistration;
}
