<?php
declare(strict_types=1);

namespace Alfa\Common\Test\Application;

use Alfa\Common\Application\ITransaction;

class TestTransaction implements ITransaction
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback)
    {
        return $callback();
    }
}
