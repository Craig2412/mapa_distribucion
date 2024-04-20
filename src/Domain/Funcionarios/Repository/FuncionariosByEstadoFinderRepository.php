<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;


final class FuncionariosByEstadoFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }
    

    public function findFuncionariosByEstado($estatusId): array
    {
        
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select([
            'total' => $query->func()->count('*'),
            'funcionarios.estado'
        ])
        ->group('funcionarios.estado');

        $query->where(['funcionarios.id_estatus' => $estatusId]);


        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
