<?php

namespace App\Domain\Bufete\Repository;

use App\Factory\QueryFactory;

final class BufeteFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findBufete(): array
    {
        $query = $this->queryFactory->newSelect('bufetes');

        $query->select(
            [
                'bufetes.id',
                'bufetes.nombre_bufete',
                'bufetes.rif',
                'bufetes.correo',
                'bufetes.telefono',             
                'bufetes.id_condicion' ,               
                'bufetes.created' ,               
                'bufetes.updated'                
            ]
            );

        $query->where(['bufetes.id_condicion' => 1]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
