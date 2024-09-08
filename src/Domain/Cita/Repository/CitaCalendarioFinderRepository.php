<?php

namespace App\Domain\Cita\Repository;

use App\Factory\QueryFactory;

final class CitaCalendarioFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCitaCalendario($nro_pag,$cant_registros,$fecha_inicial,$fecha_final): array
    {
        //Paginador
            $limit = $cant_registros;
            $offset = ($nro_pag - 1) * $limit;
            $query = $this->queryFactory->newSelect('citas');
        //Fin Paginador
        
        $query->select(
            [
                'citas.id',
                'citas.fecha_cita',
                'citas.id_requerimiento',
                'citas.id_estado',
                'estados.estado',
                'requerimientos.id_usuario',
                'usuarios.nombre',

                'citas.id_formato_cita',
                'formato_citas.formato_cita',
                'citas.id_condicion',
            
                'citas.created',
                'citas.updated'                 
            ]
        )

        ->leftjoin(['estados'=>'estados'], 'estados.id = citas.id_estado')
        ->leftjoin(['formato_citas'=>'formato_citas'], 'formato_citas.id = citas.id_formato_cita')
        ->leftjoin(['requerimientos'=>'requerimientos'], 'requerimientos.id = citas.id_requerimiento')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = requerimientos.id_usuario')

        ->where(function ($exp, $q) use ($fecha_inicial, $fecha_final) {
            return $exp->between('citas.fecha_cita', $fecha_inicial, $fecha_final);
        }, []);
        
        //Paginador
            $query->offset([$offset]);
            $query->limit([$limit]);
        //Fin paginador
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
