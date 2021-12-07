<?php

namespace App\DTO;

/**
 * Class BaseInputDTO
 * @package App\DTO
 */
abstract class BaseInputDTO
{
    /**
     * Mass assignment of object fields
     *
     * @param array $fields
     * @return BaseInputDTO
     */
    public function fill(array $fields): self
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = $value;
        }

        return $this;
    }
}
