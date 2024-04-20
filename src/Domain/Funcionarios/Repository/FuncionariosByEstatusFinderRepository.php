<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;


final class FuncionariosByEstatusFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }
    

    public function findFuncionariosByEstatus($estatusId): array
    {
        
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select([
            'total' => $query->func()->count('*'),
            'estatus.estatus'
        ])
        ->leftJoin('estatus', 'estatus.id = funcionarios.id_estatus')
        ->group('funcionarios.id_estatus');

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
