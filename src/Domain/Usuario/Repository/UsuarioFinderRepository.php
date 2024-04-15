<?php

namespace App\Domain\Usuario\Repository;

use App\Factory\QueryFactory;

final class UsuarioFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findUsuarios(): array
    {
        $query = $this->queryFactory->newSelect('users');

        $query->select(
            [
                'users.id',
                'users.name',
                'users.identification',
                'users.email',
                'users.id_role',
                'roles.role',
                'users.created',
                'users.updated'
            ]
        )
        
        ->leftjoin(['roles'=>'roles'], 'roles.id = users.id_role');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
