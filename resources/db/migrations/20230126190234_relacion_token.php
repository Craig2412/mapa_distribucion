<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RelacionToken extends AbstractMigration
{
    public function change(): void
    {

        $table = $this->table('tokens');
        $table   ->addForeignKey(['id_usuario'],'usuarios',['id'],['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'id_usuarioToken'])
                        ->save();
    }
}
