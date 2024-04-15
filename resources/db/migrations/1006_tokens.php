<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Tokens extends AbstractMigration
{
    public function change(): void
    {
        $tokens = $this->table('tokens');
        $tokens   ->addColumn('token', 'string', ['limit' => 1501])
                  ->addColumn('id_user', 'integer', ['signed' => false])
                  ->addColumn('created', 'datetime')
                  ->addColumn('updated', 'datetime', ['null' => true])

                  ->addIndex('id_user')
                  ->create();
    }
}
