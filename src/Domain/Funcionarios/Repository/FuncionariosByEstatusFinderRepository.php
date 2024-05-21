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

        if ($where != "ADMINISTRADOR") {
            $query->where(['funcionarios.entidad_adscripcion' => $where]); 
        }

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
