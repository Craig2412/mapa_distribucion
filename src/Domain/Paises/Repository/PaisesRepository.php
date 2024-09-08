<?php

namespace App\Domain\Paises\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class PaisesRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
   
    public function getPaisesById(int $paisesId): array
    {
        $query = $this->queryFactory->newSelect('paises');
        $query->select(
            [
                'paises.id',
                'paises.pais'
            ]
        );

        $query->where(['paises.id'=> $paisesId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Paises no encontrados: %s', $paisesId));
        }
        
        return $row;
    }
    

    public function existsPaisesId(int $paisesId): bool
    {
        $query = $this->queryFactory->newSelect('paises');
        $query->select('id')->where(['id' => $paisesId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    
}
