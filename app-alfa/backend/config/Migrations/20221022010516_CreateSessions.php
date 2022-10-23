<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSessions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('sessions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'char', ['default' => null, 'limit' => 40, 'null' => false])
            ->addColumn('data', 'blob', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('expires', 'integer', ['default' => null, 'limit' => 10, 'null' => false, 'signed' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();
    }
}
