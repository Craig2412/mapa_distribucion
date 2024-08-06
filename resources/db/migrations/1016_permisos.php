<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Permisos extends AbstractMigration
{
    public function change(): void
    {
        $permisos = $this->table('permisos');
        $permisos   ->addColumn('nombre', 'string', ['limit' => 100])
                    ->addColumn('guard_name', 'string', ['limit' => 50])
                    ->addColumn('created', 'datetime')
                    ->addColumn('updated', 'datetime', ['null' => true])

                 ->create();
    }
}
