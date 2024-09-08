<?php

namespace App\Domain\UsuariosAreas\Repository;

use App\Factory\QueryFactory;

final class UsuariosAreasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findUsuariosAreas(): array
    {
        $query = $this->queryFactory->newSelect('usuarios_area');

        $query->select(
            [
                'usuarios_area.id',
                'usuarios_area.id_usuario',
                'usuarios_area.id_area',
                'usuarios.nombre',
                'areas.area'
            ]
        )
        ->leftjoin(['areas'=>'areas'], 'areas.id = usuarios_area.id_area')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = usuarios_area.id_usuario');
        
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
