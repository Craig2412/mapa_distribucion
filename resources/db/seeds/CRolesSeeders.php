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
            ]
            ];

        $posts = $this->table('roles');
        $posts->insert($data)
              ->saveData();
    }
}
