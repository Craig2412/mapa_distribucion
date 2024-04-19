<?php


use Phinx\Seed\AbstractSeed;

class CConfiguracion extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id'    => 1,
                'nombre_entidad_principal'    => 'POR DEFINIR',
                'nombre_entidad'    => 'POR DEFINIR',
                'id_estatus_aplicacion'    => 1
            ]
            ];

        $posts = $this->table('configuracion');
        $posts->insert($data)
              ->saveData();
    }
}
