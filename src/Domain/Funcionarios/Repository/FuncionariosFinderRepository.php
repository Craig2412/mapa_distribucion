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

    public function findFuncionarioss(): array
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
                'funcionarios.created',
                'funcionarios.updated'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus');

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
