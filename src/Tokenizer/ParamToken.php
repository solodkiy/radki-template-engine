<?php

declare(strict_types=1);

namespace Radki\TemplateEngine\Tokenizer;

class ParamToken
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $isArray;

    /**
     * @var bool
     */
    private $isNullable;

    /**
     * ParamToken constructor.
     * @param $name
     * @param $type
     * @param $isArray
     * @param $isNullable
     */
    public function __construct(string $name, string $type, bool $isArray = false, bool $isNullable = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->isArray = $isArray;
        $this->isNullable = $isNullable;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isArray(): bool
    {
        return $this->isArray;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
