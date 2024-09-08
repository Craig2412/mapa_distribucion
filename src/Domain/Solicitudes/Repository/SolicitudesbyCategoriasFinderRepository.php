<?php

namespace App\Domain\Solicitudes\Repository;

use App\Factory\QueryFactory;

final class SolicitudesbyCategoriasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findSolicitudesbyCategorias(): array
    {
        
        $query = $this->queryFactory->newSelect('estados');
        $query->select([
            'total' => $query->func()->count('CASE WHEN agents.id IS NOT NULL AND agents.id_condition = TRUE THEN 1 END'),
            'estados.estado'
        ])
        ->leftJoin('direcction', 'direcction.direcction_estado = estados.id_estado')
        ->leftJoin('agents', 'agents.id = direcction.direcction_id_agent')
        ->group('estados.estado');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
