<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Encuesta extends AbstractMigration
{
 
    public function change(): void
    {
        $encuesta = $this->table('encuesta');
        $encuesta       ->addColumn('id_funcionario', 'integer' ,  ['null' => false, 'signed' => false])
                        ->addColumn('id_pregunta', 'integer' ,  ['null' => false, 'signed' => false])
                        ->addColumn('respuesta', 'string' , ['limit' =>250])        
                        
                        ->addColumn('created', 'datetime')
                        ->addColumn('updated', 'datetime', ['null' => true])

                        ->addIndex('id_funcionario')
                        ->addIndex('id_pregunta')
                        
                        ->create();
    }
}
