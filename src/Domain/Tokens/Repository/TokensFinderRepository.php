<?php

namespace App\Domain\Tokens\Repository;

use App\Factory\QueryFactory;

final class TokensFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTokenss(): array
    {
        $query = $this->queryFactory->newSelect('tokens');

        $query->select(
            [
                'tokens.id',
                'tokens.token',
                'tokens.id_usuario',
                'usuarios.nombre',
                'usuarios.apellido',
                'tokens.created',
                'tokens.updated'
            ]
        )
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = tokens.id_usuario');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
