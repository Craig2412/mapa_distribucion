<?php

namespace App\Domain\Estados_Paises\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class Estados_PaisesRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
   
    public function getEstados_PaisesById(int $estados_paisesId): array
    {
        $query = $this->queryFactory->newSelect('estados_paises');
        $query->select(
            [
                'estados_paises.id',
                'estados_paises.estado_pais'
            ]
        );

        $query->where(['estados_paises.id'=> $estados_paisesId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Estados_Paises no encontrados: %s', $estados_paisesId));
        }
        
        return $row;
    }
    

    public function existsEstados_PaisesId(int $estados_paisesId): bool
    {
        $query = $this->queryFactory->newSelect('estados_paises');
        $query->select('id')->where(['id' => $estados_paisesId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    
}
