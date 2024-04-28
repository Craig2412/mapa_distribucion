<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionAdscripciones extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('adscripciones');
        $table   ->addForeignKey(['id_role'],'roles',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_roleAdscripciones'])
                 ->save();
    }
}
