<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionFuncionarios extends AbstractMigration
{
   public function change(): void
    {
        $table = $this->table('funcionarios');
        $table   ->addForeignKey(['id_estatus'],'estatus',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_estatusFuncionarios'])
                 ->save();
    }
}
