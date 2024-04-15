<?php


use Phinx\Seed\AbstractSeed;

class AEstatus extends AbstractSeed
{
    
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'estatus'    => 'SI'
            ],[
                'id'    => 2,
                'estatus'    => 'NO'
    
            ],[
                'id'    => 3,
                'estatus'    => 'SIN DEFINIR'
            ]
            ];

        $posts = $this->table('estatus');
        $posts->insert($data)
              ->saveData();
    }
}
