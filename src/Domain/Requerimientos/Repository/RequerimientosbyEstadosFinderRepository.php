<?php

namespace App\Domain\Requerimientos\Repository;

use App\Factory\QueryFactory;

final class RequerimientosbyEstadosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRequerimientosbyEstados(): array
    {
        
        $query = $this->queryFactory->newSelect('agents');
        $query->select([
            'total' => $query->func()->count('*')
        ])
        ->innerJoin('direcction', 'direcction.direcction_id_agent = agents.id');
        $query->where(['agents.id_condition' => true]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
    public function findRequerimientosbyVisitas(): array
    {
        
        $query = $this->queryFactory->newSelect('user_requests');
        $query->select([
            'total' => $query->func()->count('*')
        ]);
        $query->where(['user_requests.user_requests_ip !=' => '10.100.2.121']);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
