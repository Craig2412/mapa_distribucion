<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionEncuesta extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('encuesta');
        $table   ->addForeignKey(['id_funcionario'],'funcionarios',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_estatusEncuestas'])
                 ->addForeignKey(['id_pregunta'],'preguntas',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_preguntasEncuestas'])
                 ->save();
    }
}
