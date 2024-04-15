<?php


use Phinx\Seed\AbstractSeed;

class APreguntas extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'pregunta'    => 'TIEMPO DE VOTACION',
                'etiqueta' => 'TDV'
            ],[
                'id'    => 2,
                'pregunta'    => 'ALGUNA INCIDENCIA',
                'etiqueta' => 'AI'   
            ]
            ];

        $posts = $this->table('preguntas');
        $posts->insert($data)
              ->saveData();
    }
}
