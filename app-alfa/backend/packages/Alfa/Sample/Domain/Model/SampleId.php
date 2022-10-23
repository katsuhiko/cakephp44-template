<?php
declare(strict_types=1);

namespace Alfa\Sample\Domain\Model;

use Alfa\Common\Domain\Library\AlfaText;
use Alfa\Common\Domain\Model\InvalidArgumentException;
use Alfa\Common\Domain\Model\ValueObjectStringTrait;

final class SampleId
{
    use ValueObjectStringTrait;

    /**
     * @return self
     */
    public static function newId(): self
    {
        return new self(AlfaText::id());
    }

    /**
     * @param string $value value
     */
    public function __construct(
        private string $value
    ) {
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] SampleId 不正な値です。");
        }
    }

    /**
     * @param string $value value
     * @return bool
     */
    public static function validate(string $value)
    {
        if ($value === '') {
            return false;
        }

        return true;
    }

    /**
     * @param self $obj obj
     * @return bool
     */
    public function equals(SampleId $obj): bool
    {
        return $this->value === $obj->value;
    }
}
