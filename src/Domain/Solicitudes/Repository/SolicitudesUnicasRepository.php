<?php

namespace App\Domain\Solicitudes\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class SolicitudesUnicasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("d-m-Y H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function getSolicitudesUnicasById(int $solicitudesUnicasId): array
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

        $query->where(['solicitudes.id_condicion' => 1,'solicitudes.id' => $solicitudesUnicasId]);
         

        $row = $query->execute()->fetchAll('assoc');
        if (!$row) {
            throw new DomainException(sprintf('SolicitudesUnicas not found: %s', $solicitudesUnicasId));
        }

        return $row;
    }

        
}