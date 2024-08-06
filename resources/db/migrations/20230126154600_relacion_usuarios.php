<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionUsuarios extends AbstractMigration
{
    public function up()
    {

        $usuarios = $this->table('usuarios');
        $usuarios->addForeignKey(['id_rol'],'roles',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_rolUsuarios'])
                 ->addForeignKey(['id_condicion'],'condiciones',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_condicionUsuarios'])
                 ->save();
       
    }
}
