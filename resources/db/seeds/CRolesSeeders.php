<?php


use Phinx\Seed\AbstractSeed;

class CRolesSeeders extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'role'    => 'ADMINISTRADOR'
            ],[
                'id'    => 2,
                'role'    => 'COMERCIO NACIONAL'
            ],[
                'id'    => 3,
                'role'    => 'SAPI'
            ],[
                'id'    => 4,
                'role'    => 'SENCAMER'
            ]
            ];

        $posts = $this->table('roles');
        $posts->insert($data)
              ->saveData();
    }
}
