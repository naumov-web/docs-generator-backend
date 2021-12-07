<?php

use App\Enums\RoleSystemNamesEnum;

return [
    'roles' => [
        [
            'system_name' => RoleSystemNamesEnum::USER,
            'name' => 'User'
        ],
        [
            'system_name' => RoleSystemNamesEnum::COMPANY_OWNER,
            'name' => 'Company owner'
        ]
    ]
];
