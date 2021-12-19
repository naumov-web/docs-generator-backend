<?php

declare(strict_types=1);

namespace App\DTO\Common;

/**
 * Class FileDTO
 * @package App\DTO\Common
 */
final class FileDTO
{
    /**
     * File name value
     * @var string
     */
    private string $name;

    /**
     * File mime value
     * @var string
     */
    private string $mime;

    /**
     * File content value
     * @var string
     */
    private string $content;

    /**
     * FileDTO constructor
     * @param string $name
     * @param string $mime
     * @param string $content
     */
    public function __construct(string $name, string $mime, string $content)
    {
        $this->name = $name;
        $this->mime = $mime;
        $this->content = $content;
    }

    /**
     * Get name value
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get mime value
     *
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * Get content value
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
