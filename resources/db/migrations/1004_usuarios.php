<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Usuarios extends AbstractMigration{
    
    public function change(): void{
        
        $usuarios = $this->table('usuarios');
        $usuarios->addColumn('nombre', 'string', ['limit' => 100])
                 ->addColumn('apellido', 'string', ['limit' => 100])
                 ->addColumn('correo', 'string' , ['limit' => 100])
                 ->addColumn('identificacion', 'string' , ['limit' => 15])
                 ->addColumn('clave', 'string' , ['limit' => 255])
                 ->addColumn('telefono', 'string' , ['limit' => 11])        
                 ->addColumn('id_rol', 'integer' , ['null' => false, 'signed' => false, 'default'=> 1])
                 ->addColumn('id_condicion', 'integer' , ['null' => false, 'signed' => false, 'default'=> 1])    
                 ->addColumn('created', 'datetime')
                 ->addColumn('updated', 'datetime', ['null' => true])

                 ->addIndex('id_rol')
                 ->addIndex('id_condicion')
                 ->addIndex('identificacion', ['unique' => true])
                 ->addIndex('telefono', ['unique' => true])
                 ->addIndex('correo', ['unique' => true])
                 
                  ->create();
    }
}
