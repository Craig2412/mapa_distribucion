<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Preguntas extends AbstractMigration
{
    public function change(): void
    {
        $preguntas = $this->table('preguntas');
        $preguntas      ->addColumn('pregunta', 'string' , ['limit' => 100])        
                        ->addColumn('etiqueta', 'string' , ['limit' => 100])        
                        ->create();
    }
}
