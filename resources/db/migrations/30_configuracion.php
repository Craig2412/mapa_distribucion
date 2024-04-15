<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Configuracion extends AbstractMigration
{
    public function change(): void
    {
        $configuracion = $this->table('configuracion');
        $configuracion  ->addColumn('nombre_entidad', 'string' , ['limit' =>250])        
                        ->addColumn('id_estatus_aplicacion', 'integer' ,  ['null' => false, 'signed' => false])
            
                        ->addIndex('id_estatus_aplicacion')
                        
                        ->create();
    }
}
