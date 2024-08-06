<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration{
    
    public function change(): void{
        
        $usuarios = $this->table('users');
        $usuarios->addColumn('name', 'string', ['limit' => 100])
                 ->addColumn('email', 'string' , ['limit' => 100])
                 ->addColumn('identification', 'string' , ['limit' => 15])
                 ->addColumn('pass', 'string' , ['limit' => 255])      
                 ->addColumn('id_role', 'integer' , ['null' => false, 'signed' => false, 'default'=> 1])  

                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_role')
                 ->addIndex('identification', ['unique' => true])
                 ->addIndex('email', ['unique' => true])
                 
                  ->create();
    }
}
