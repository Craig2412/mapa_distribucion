<?php

namespace App\Domain\UsuariosBufetes\Repository;

use App\Factory\QueryFactory;

final class UsuariosBufetesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findUsuariosBufetes(): array
    {
        $query = $this->queryFactory->newSelect('usuarios_bufetes');

        $query->select(
            [
                'usuarios_bufetes.id',
                'usuarios_bufetes.id_usuario',
                'usuarios_bufetes.id_bufete',
                'usuarios.nombre',
                'bufetes.nombre_bufete'
            ]
        )
        ->leftjoin(['bufetes'=>'bufetes'], 'bufetes.id = usuarios_bufetes.id_bufete')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = usuarios_bufetes.id_usuario');
        
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
