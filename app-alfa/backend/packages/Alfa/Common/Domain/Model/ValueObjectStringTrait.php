<?php
declare(strict_types=1);

namespace Alfa\Common\Domain\Model;

trait ValueObjectStringTrait
{
    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->asString();
    }
}
