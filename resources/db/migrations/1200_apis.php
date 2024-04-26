<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Apis extends AbstractMigration
{
    public function change(): void{
        
        $apis = $this->table('apis');
        $apis    ->addColumn('nombre_entidad', 'string', ['limit' => 200])
                 ->addColumn('id_entidad_principal', 'integer' , ['null' => false, 'signed' => false, 'default'=> 1])  
                 ->addColumn('url', 'string' , ['limit' => 1000])
                 
                 ->addIndex('id_entidad_principal')
                 ->addIndex('url', ['unique' => true])
                 
                  ->create();
    }
}
