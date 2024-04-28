<?php


use Phinx\Seed\AbstractSeed;

class DAdscripciones extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'id_role'    => '2',
                'ente' => 'COMERCIO NACIONAL'
            ],[
                'id'    => 2,
                'id_role'    => '2',
                'ente' => 'SAPI'
            ],[
                'id'    => 3,
                'id_role'    => '2',
                'ente' => 'SENCAMER'
            ]
            ];

        $posts = $this->table('adscripciones');
        $posts->insert($data)
              ->saveData();
    }
}
