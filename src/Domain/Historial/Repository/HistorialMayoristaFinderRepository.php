<?php

namespace App\Domain\Historial\Repository;

use App\Factory\QueryFactory;

final class HistorialMayoristaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findHistorialMayoristas($id_mayorista): array
    {
        $query = $this->queryFactory->newSelect('historiaL_mayorista');

        $query->select(
            [
                'id',
                'id_mayorista',
                'campo',
                'dato_nuevo',
                'fecha'
            ]
        );
        $query->where(['historial_mayorista.id_mayorista' => $id_mayorista]);



        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
