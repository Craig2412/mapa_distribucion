<?php


use Phinx\Seed\AbstractSeed;

class AEstatus extends AbstractSeed
{
    
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'estatus'    => 'Estatus 1'
            ],[
                'id'    => 2,
                'estatus'    => 'Estatus 2'
    
            ],[
                'id'    => 3,
                'estatus'    => 'Estatus 3'
            ]
            ];

        $posts = $this->table('estatus');
        $posts->insert($data)
              ->saveData();
    }
}
