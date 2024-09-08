<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;

final class FuncionariosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFuncionarioss($where): array
    {
        $query = $this->queryFactory->newSelect('funcionarios');

        $query->select(
            [
                'funcionarios.id',
                'funcionarios.cedula',
                'funcionarios.apellidos_nombres',
                'funcionarios.estado',
                'funcionarios.id_estatus',
                'estatus.estatus',
                'funcionarios.entidad_adscripcion',
                'IFNULL(repeticiones.cantidad_repeticiones, 0) AS cantidad_repeticiones',
                'IFNULL(repeticiones_check.cantidad_repeticiones_check, 0) AS cantidad_repeticiones_check'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus')
         ->leftjoin(
            ['repeticiones' => $this->queryFactory->newSelect('funcionarios')
                ->select(['funcionarios.responsable', 'COUNT(*) AS cantidad_repeticiones'])
                ->group(['funcionarios.responsable'])
            ],
            'funcionarios.cedula = repeticiones.responsable'
        )
         ->leftjoin(
            ['repeticiones_check' => $this->queryFactory->newSelect('funcionarios')
                ->select(['funcionarios.responsable', 'COUNT(*) AS cantidad_repeticiones_check'])
                ->where(['funcionarios.id_estatus' => 1])
                ->group(['funcionarios.responsable'])
            ],
            'funcionarios.cedula = repeticiones_check.responsable'
        );

        if (isset($where)) {
                        
            $conditions = [];
            foreach ($where as $key => $value) {
                $conditions[] = [$value => $key];
            }
            $query->where([
                'OR' => $conditions                
            ]);
            
        }
        
        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}


/*
 public function findFuncionarioss($where): array
    {
        $query = $this->queryFactory->newSelect('funcionarios');

        $query->select(
            [
                'funcionarios.id',
                'funcionarios.cedula',
                'funcionarios.apellidos_nombres',
                'funcionarios.telefono',
                'funcionarios.correo',
                'funcionarios.serial_carnet',
                'funcionarios.codigo_carnet',
                'funcionarios.estado',
                'funcionarios.municipio',
                'funcionarios.localidad',
                'funcionarios.nombre_centro_votacion',
                'funcionarios.id_estatus',
                'estatus.estatus',
                'funcionarios.departamento',
                'funcionarios.entidad_adscripcion',
                'funcionarios.entidad_principal',
                'funcionarios.created',
                'funcionarios.updated',
                'IFNULL(repeticiones.cantidad_repeticiones, 0) AS cantidad_repeticiones',
                'IFNULL(repeticiones_check.cantidad_repeticiones_check, 0) AS cantidad_repeticiones_check'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus')
         ->leftjoin(
            ['repeticiones' => $this->queryFactory->newSelect('funcionarios')
                ->select(['funcionarios.responsable', 'COUNT(*) AS cantidad_repeticiones'])
                ->group(['funcionarios.responsable'])
            ],
            'funcionarios.cedula = repeticiones.responsable'
        )
         ->leftjoin(
            ['repeticiones_check' => $this->queryFactory->newSelect('funcionarios')
                ->select(['funcionarios.responsable', 'COUNT(*) AS cantidad_repeticiones_check'])
                ->where(['funcionarios.id_estatus' => 1])
                ->group(['funcionarios.responsable'])
            ],
            'funcionarios.cedula = repeticiones_check.responsable'
        );

        if (isset($where)) {
            
            
            $conditions = [];
            foreach ($where as $key => $value) {
                $conditions[] = [$value => $key];
            }
            $query->where([
                'OR' => $conditions                
            ]);
            
            //$query->where($conditions, [], [], 'OR');
        }
        
        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
*/
