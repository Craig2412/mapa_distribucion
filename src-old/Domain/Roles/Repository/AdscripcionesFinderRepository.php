<?php

namespace App\Domain\Roles\Repository;

use App\Factory\QueryFactory;

final class AdscripcionesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findAdscripcioness($id_rol,$ente): array
    {       
        switch ($id_rol) {
            case 1:
                $query = $this->queryFactory->newSelect('adscripciones');
                $query->select(
                    [
                        'adscripciones.id',
                        'adscripciones.ente',
                        'roles.role'              
                    ]
                )->leftJoin('roles', 'roles.id = adscripciones.id_role');
                
                $return = $query->execute()->fetchAll('assoc') ?: [];
                break;
            
            default:
                $query = $this->queryFactory->newSelect('adscripciones');

                $query->select(
                    [
                        'adscripciones.id',
                        'adscripciones.ente',
                        'roles.role'              
                    ]
                )->leftJoin('roles', 'roles.id = adscripciones.id_role');
                
                $query->where(['id_role' => $id_rol]);
                $return = $query->execute()->fetchAll('assoc') ?: [];

                if (count($return) == 0) {
                    $query = $this->queryFactory->newSelect('adscripciones');
                    $query->select(
                        [
                            'adscripciones.id',
                            'adscripciones.ente', 
                            'roles.role'                 
                        ]
                    )->leftJoin('roles', 'roles.id = adscripciones.id_role');
                    
                    $query->where(['adscripciones.ente' => $ente]);
                    $return = $query->execute()->fetchAll('assoc') ?: [];
                }

                break;
        }
        



        

        
           

        return $return;
    }
}
