<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;

final class FuncionariosWhereGenFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFuncionariosWhereGens(int $id_rol, string $rol): array
    {
        $query = $this->queryFactory->newSelect('adscripciones');
        $query->select(
            [
                'adscripciones.ente'
            ]
        );   
        switch ($id_rol) {
            case '1':
                
                break;
            
            default:
                
            $query->where(['adscripciones.id_role' => $id_rol]);

                break;
        }

        $return = $query->execute()->fetchAll('assoc') ?: [];

        if (count($query->execute()->fetchAll('assoc') ?: []) > 0) {
            return $return;
        }else {
            $query->where(['adscripciones.ente' => $rol]);

            return $query->execute()->fetchAll('assoc') ?: [];
        }
    }
}
