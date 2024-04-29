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
                'funcionarios.updated'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus');

        if (isset($where)) {
            /*
            */
            
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
}
