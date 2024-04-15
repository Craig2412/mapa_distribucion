<?php


use Phinx\Seed\AbstractSeed;

class AEstatusAplicacion extends AbstractSeed
{
    
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'estatus_aplicacion'    => 'NUEVA'
            ],[
                'id'    => 2,
                'estatus_aplicacion'    => 'ACTIVO'
    
            ],[
                'id'    => 3,
                'estatus_aplicacion'    => 'DETENIDO'
            ]
            ];

        $posts = $this->table('estatus_aplicacion');
        $posts->insert($data)
              ->saveData();
    }
}
