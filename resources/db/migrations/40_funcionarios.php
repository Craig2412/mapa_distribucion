<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Funcionarios extends AbstractMigration
{
   
    public function change(): void
    {
        $funcionarios = $this->table('funcionarios');
        $funcionarios   ->addColumn('cedula', 'string' , ['limit' => 10])
                        ->addColumn('apellidos_nombres',  'string' , ['limit' => 200])
                        ->addColumn('telefono', 'string' , ['limit' => 11])        
                        ->addColumn('correo', 'string' , ['limit' => 100])
                        ->addColumn('serial_carnet', 'string' , ['limit' => 10])
                        ->addColumn('codigo_carnet', 'string' , ['limit' => 10])
                        ->addColumn('estado', 'string' , ['limit' => 100])
                        ->addColumn('municipio', 'string' , ['limit' => 100])
                        ->addColumn('localidad', 'string' , ['limit' => 100])
                        ->addColumn('nombre_centro_votacion', 'string' , ['limit' => 100])
                        ->addColumn('id_estatus', 'integer' , ['null' => false, 'signed' => false, 'default' => 3])

                        ->addColumn('created', 'datetime')
                        ->addColumn('updated', 'datetime', ['null' => true])
                        
                        ->addIndex('id_estatus')
                        ->addIndex('cedula', ['unique' => true])

                        ->create();
    }
}
