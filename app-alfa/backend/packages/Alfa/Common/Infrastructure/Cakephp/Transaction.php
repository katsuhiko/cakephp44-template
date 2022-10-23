<?php
declare(strict_types=1);

namespace Alfa\Common\Infrastructure\Cakephp;

use Cake\Datasource\ConnectionManager;
use Alfa\Common\Application\ITransaction;

class Transaction implements ITransaction
{
    /**
     * @inheritDoc
     */
    public function transactional(callable $callback)
    {
        $connection = ConnectionManager::get('default');

        return $connection->transactional($callback);
    }
}
