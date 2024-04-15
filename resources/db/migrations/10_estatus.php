<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Estatus extends AbstractMigration
{
    
    public function change(): void
    {
        $estatus = $this->table('estatus');
        $estatus       ->addColumn('estatus', 'string' ,  ['limit' => 100])
                       ->create();
    }
}
