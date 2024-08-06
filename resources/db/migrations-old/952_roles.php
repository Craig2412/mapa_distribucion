<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Roles extends AbstractMigration
{
    public function change(): void
    {
        $roles = $this->table('roles');
        $roles   ->addColumn('role', 'string', ['limit' => 100])

                 ->addIndex('role' , ['unique' => true])
                 ->create();
    }
}
