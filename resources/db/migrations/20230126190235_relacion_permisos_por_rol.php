<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionPermisosPorRol extends AbstractMigration
{
    public function change(): void
    {

        $permisos_por_rol = $this->table('permisos_por_rol');
        $permisos_por_rol   ->addForeignKey(['id_permisos'],'permisos',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_permiRole'])
                            ->addForeignKey(['id_rol'],'roles',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_rolPermi'])
                            ->addForeignKey(['id_condicion'],'condiciones',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_condicionPermi'])
                            
                            ->save();
    }
}