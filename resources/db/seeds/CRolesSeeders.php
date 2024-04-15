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
                'role'    => 'USUARIO'
            ],[
                'id'    => 3,
                'role'    => 'VISUALIZADOR'
            ]
            ];

        $posts = $this->table('roles');
        $posts->insert($data)
              ->saveData();
    }
}
