<?php
declare(strict_types=1);

namespace Alfa\Common\Application;

interface ITransaction
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback);
}
