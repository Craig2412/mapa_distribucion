<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Adscripciones extends AbstractMigration
{
    public function change(): void
    {
        $adscipciones = $this->table('adscripciones');
        $adscipciones  ->addColumn('ente', 'string' , ['limit' =>250])      
                       ->addColumn('id_role', 'integer' , ['null' => false, 'signed' => false, 'default'=> 1])  
            
                        ->addIndex('id_role')
                        
                        ->create();
    }
}
