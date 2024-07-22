<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;

final class FuncionariosResponsableFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFuncionariosResponsables($cedulaResponsable): array
    {
        $query = $this->queryFactory->newSelect('funcionarios');

        $query->select(
            [
                'funcionarios.id',
                'funcionarios.cedula',
                'funcionarios.apellidos_nombres',
                'funcionarios.telefono',
                'funcionarios.estado',
                'funcionarios.id_estatus',
                'estatus.estatus',
                'funcionarios.entidad_adscripcion'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus');

        $query->where(['funcionarios.responsable' => $cedulaResponsable]);       
        
        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}

