<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Permisos extends AbstractMigration
{
    public function change(): void
    {
        $permisos = $this->table('permisos');
        $permisos       ->addColumn('permiso', 'string' ,  ['limit' => 100])
                        ->addColumn('permiso', 'string' ,  ['limit' => 100])
                        ->addColumn('permiso', 'string' ,  ['limit' => 100])
                        ->addColumn('permiso', 'string' ,  ['limit' => 100])
                        ->create();
    }
}
