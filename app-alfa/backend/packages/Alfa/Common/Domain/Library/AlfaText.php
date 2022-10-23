<?php
declare(strict_types=1);

namespace Alfa\Common\Domain\Library;

use Ulid\Ulid;

final class AlfaText
{
    /**
     * @return string
     */
    public static function id(): string
    {
        return (string)Ulid::generate();
    }
}
