<?php

namespace App\Domain\Cita\Repository;

use App\Factory\QueryFactory;

final class CitaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCita($nro_pag,$where,$cant_registros): array
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
                'citas.id_formato_cita',
                'formato_citas.formato_cita',
                'requerimientos.id_usuario',
                'usuarios.nombre',
                'usuarios.apellido',

                'citas.id_condicion',
                'citas.created',
                'citas.updated'
            ]
        )
        ->leftjoin(['estados'=>'estados'], 'estados.id = citas.id_estado')
        ->leftjoin(['formato_citas'=>'formato_citas'], 'formato_citas.id = citas.id_formato_cita')
        ->leftjoin(['requerimientos'=>'requerimientos'], 'requerimientos.id = citas.id_requerimiento')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = requerimientos.id_usuario'); 
        
        //Paginador
            if (!empty($where)) {
                $query->where(['citas.id_condicion' => 1,$where]);  
            }    else {
                # code...
                $query->where(['citas.id_condicion' => 1]);
            }      

            $query->offset([$offset]);
            $query->limit([$limit]);
        //Fin paginador

//var_dump($query->execute()->fetchAll('assoc'));
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
