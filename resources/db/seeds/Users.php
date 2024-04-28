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
                'identification'    => 'V026745014',
                'pass'    => '$2a$12$LkAcrJN27WZX/VHXsKuH4usX9axTWMvMaZMwhd5l1Ad0JaL62oIkG',//123
                'id_role'    => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 2,
                'name'    => 'Ely',
                'email'    => 'elychirivella10@gmail.com',
                'identification'    => 'V027038432',
                'pass'    => '$2a$12$LkAcrJN27WZX/VHXsKuH4usX9axTWMvMaZMwhd5l1Ad0JaL62oIkG',//123
                'id_role'    => 1,
                'created' => date('Y-m-d H:i:s'),
                'updated' => null
            ],[
                'id'    => 3,
                'name'    => 'Briguel',
                'email'    => 'brigueluis@gmail.com',
                'identification'    => 'V016395558',
                'pass'    => '$2a$12$LkAcrJN27WZX/VHXsKuH4usX9axTWMvMaZMwhd5l1Ad0JaL62oIkG',//123
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
