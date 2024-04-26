<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelationApis extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('apis');
        $table->addForeignKey(['id_entidad_principal'],'entidades_principales',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_entidad_principalApis'])
                        ->save();
    }
}
