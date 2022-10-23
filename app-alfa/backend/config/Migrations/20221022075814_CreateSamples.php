<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSamples extends AbstractMigration
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
        $table = $this->table('samples', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'uuid', ['default' => null, 'null' => false, 'comment' => 'ID'])
            ->addColumn('title', 'char', ['default' => null, 'limit' => 40, 'null' => false, 'comment' => 'タイトル'])
            ->addColumn('content', 'text', ['default' => null, 'limit' => null, 'null' => false, 'comment' => '内容'])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false]);
        $table->create();
    }
}
