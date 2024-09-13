<?php

namespace App\Domain\FormasMovilizacion\Repository;

use App\Factory\QueryFactory;

final class FormasMovilizacionFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFormasMovilizacions($id_mayorista): array
    {
        $query = $this->queryFactory->newSelect('formas_movilizacion_mercancia');

        $query->select(
            [
                'formas_movilizacion_mercancia.id',
                'formas_movilizacion_mercancia.id_mayorista',
                'formas_movilizacion_mercancia.id_tipo_movilizacion',
                'tipos_movilizacion.tipo_movilizacion'
            ]
        )
        ->leftjoin(['tipos_movilizacion'=>'tipos_movilizacion'], 'tipos_movilizacion.id = formas_movilizacion_mercancia.id_tipo_movilizacion');
        $query->where(['formas_movilizacion_mercancia.id_mayorista' => $id_mayorista]);

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
