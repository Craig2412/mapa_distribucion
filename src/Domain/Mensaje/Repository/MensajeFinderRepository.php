<?php

namespace App\Domain\Mensaje\Repository;

use App\Factory\QueryFactory;

final class MensajeFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findMensaje($nro_pag,$where,$cant_registros,$taskId): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('mensajes');
        //Fin Paginador
        
        $query->select(
            [
                'mensajes.id',
                'mensajes.mensaje',
                'mensajes.id_usuario',
                'usuarios.nombre',
                'usuarios.apellido',
                'mensajes.id_solicitud',
                'mensajes.created',
                'mensajes.updated'
            ]
        )
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = mensajes.id_usuario');
        $query->order(['id' => 'DESC']);
        $query->where(['mensajes.id_condicion' => 1,'mensajes.id_solicitud' => $taskId]);    

        //Paginador
        
        $query->offset([$offset]);
        $query->limit([$limit]);
        //Fin paginador


        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
