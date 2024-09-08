<?php

namespace App\Domain\Solicitudes\Repository;

use App\Factory\QueryFactory;

final class SolicitudesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findSolicitudes(): array
    {
        $query = $this->queryFactory->newSelect('solicitudes');

        $query->select(
            [
                'solicitudes.id',
                'solicitudes.num_solicitud',
                'solicitudes.num_registro',
                'solicitudes.descripcion',
                'solicitudes.respuesta',
                'solicitudes.id_categoria',
                'categorias.categoria',
                'solicitudes.id_condicion',
                'solicitudes.id_requerimiento',
                'solicitudes.id_estado',
                'estados.estado',
                'solicitudes.created',
                'solicitudes.updated'
            ]
        )   
            ->leftjoin(['categorias'=>'categorias'], 'categorias.id = solicitudes.id_categoria')
            ->leftjoin(['estados'=>'estados'], 'estados.id = solicitudes.id_estado');

        $query->where(['solicitudes.id_condicion' => 1]);


        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
