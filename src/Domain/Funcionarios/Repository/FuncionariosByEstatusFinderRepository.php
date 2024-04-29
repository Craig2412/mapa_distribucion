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
    

    public function findFuncionariosByEstatus($estatusId,$where): array
    {
        
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select([
            'total' => $query->func()->count('*'),
            'estatus.estatus'
        ])
        ->leftJoin('estatus', 'estatus.id = funcionarios.id_estatus')
        ->group('funcionarios.id_estatus');

        if (isset($where)) {
                   
            $conditions = [];
            foreach ($where as $key => $value) {
                $conditions[] = [$value => $key];
            }
            $query->where([
                'OR' => $conditions                
            ]);
            
            //$query->where($conditions, [], [], 'OR');
        }

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
