<?php


use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'name'    => 'Alex',
                'email'    => 'aularalexander55@gmail.com',
                'identification'    => 'V027038431',
                'pass'    => 'V027038432',
                'id_role'    => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 2,
                'name'    => 'Ely',
                'email'    => 'elychirivella10@gmail.com',
                'identification'    => 'V027038432',
                'pass'    => 'V027038432',
                'id_role'    => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ]
        ];

        $posts = $this->table('users');
        $posts->insert($data)
              ->saveData();
    }
}
