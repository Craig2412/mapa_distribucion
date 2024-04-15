<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionConfiguracion extends AbstractMigration
{
    public function change(): void
    {

        $table = $this->table('configuracion');
        $table   ->addForeignKey(['id_estatus_aplicacion'],'estatus_aplicacion',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_estatusAppConfig'])
                 ->save();
    }
}
