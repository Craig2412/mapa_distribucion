<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;


final class FuncionariosByEstadoFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }
    

    public function findFuncionariosByEstado($tipo_total,$estatusId,$where, $tipo_busqueda): array
    {
        
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select([
            $tipo_total => $query->func()->count('*'),
            'funcionarios.estado'
        ])
        ->group('funcionarios.estado');

        if ($where == "ADMINISTRADOR") {
            $query->where(['funcionarios.id_estatus' => $estatusId]);
        }else {
            if ($tipo_busqueda == 1) {
                $query->where(['funcionarios.id_estatus' => $estatusId, 'funcionarios.entidad_principal' => $where]);
            }else{
                $query->where(['funcionarios.id_estatus' => $estatusId, 'funcionarios.entidad_adscripcion' => $where]);
            }
        }
        
        $return = $query->execute()->fetchAll('assoc') ?: [];

       // var_dump($return);
        return $return;
    }
}
