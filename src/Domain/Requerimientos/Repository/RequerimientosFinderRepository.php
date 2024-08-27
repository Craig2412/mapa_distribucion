<?php

namespace App\Domain\Requerimientos\Repository;

use App\Factory\QueryFactory;

final class RequerimientosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRequerimientos($nro_pag,$where,$cant_registros): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('agents');
        //Fin Paginador
        
        $query->select(
            [
                'agents.*',
                'UPPER(agents.agent_name) as agent_name',
                'UPPER(agents.agent_email) as agent_email',
                'UPPER(agents.agent_lastname) as agent_lastname',
               
                'estados.estado AS agent_estado'
            ]
            )
            ->innerJoin('direcction', 'direcction.direcction_id_agent = agents.id')
            ->innerJoin('estados', 'estados.id_estado = direcction.direcction_estado');
        //Paginador
        if (!empty($where)) {
            $query->where(['agents.id_condition' => 1,$where]);  
        }    else {
            $query->where(['agents.id_condition' => 1]);
        }     
        $query->offset([$offset]);
        $query->limit([$limit]);
        //Fin paginador

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
