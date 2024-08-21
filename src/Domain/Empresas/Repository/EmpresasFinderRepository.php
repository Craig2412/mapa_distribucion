<?php

namespace App\Domain\Empresas\Repository;

use App\Factory\QueryFactory;

final class EmpresasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEmpresass(): array
    {
        $query = $this->queryFactory->newSelect('datos_generales_empresa');

        $query->select(
            [
                'id',
                'razon_social',
                'coordenadas_x',
                'coordenadas_y',
                'rif',
                'id_estado',
                'id_municipio',
                'id_parroquia',
                'id_representante_legal',
                'telefono',
                'correo',
                'sector',
                'sub_sector'
            ]
        );
        
        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
