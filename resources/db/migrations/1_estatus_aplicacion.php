<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class EstatusAplicacion extends AbstractMigration
{
   
    public function change(): void
    {
        $estatus_aplicacion = $this->table('estatus_aplicacion');
        $estatus_aplicacion     ->addColumn('estatus_aplicacion', 'string' ,  ['limit' => 100])
                                ->create();
    }
}
