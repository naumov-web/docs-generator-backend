<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

/**
 * Trait UseListRules
 * @package App\Http\Requests\Traits
 */
trait UseListRules
{
    /**
     * Compose request rules for getting of entities
     *
     * @param array $columns
     * @return array
     */
    protected function composeListRules(array $columns = ['id']): array
    {
        $result = [
            'limit' => [
                'nullable',
                'integer'
            ],
            'offset' => [
                'nullable',
                'integer'
            ]
        ];

        if ($columns) {
            $result = array_merge(
                $result,
                [
                    'sort_by' => [
                        'required_with:sort_direction',
                        'in:' . implode(',', $columns)
                    ],
                    'sort_direction' => [
                        'required_with:sort_by',
                        'in:asc,desc'
                    ]
                ]
            );
        }

        return $result;
    }
}
