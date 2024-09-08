<?php

namespace App\Domain\Estatus_aplicacion\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class Estatus_aplicacionRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertEstatus_aplicacion(array $estatus_aplicacion): int
    {
        return (int)$this->queryFactory->newInsert('estatus_aplicacion', $this->toRow($estatus_aplicacion))
        ->execute()
        ->lastInsertId();
    }
    
    public function getEstatus_aplicacionById(int $estatus_aplicacionId): array
    {
        $query = $this->queryFactory->newSelect('estatus_aplicacion');
        $query->select(
            [
                'id',
                'estatus_aplicacion'
                ]
            );
            
            $query->where(['id' => $estatus_aplicacionId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Estatus_aplicacion not found: %s', $estatus_aplicacionId));
        }
        
        return $row;
    }
    
    public function updateEstatus_aplicacion(int $estatus_aplicacionId, array $estatus_aplicacion): array
    {
        $row = $this->toRow($estatus_aplicacion);
        
        $this->queryFactory->newUpdate('estatus_aplicacion', $row)
        ->where(['id' => $estatus_aplicacionId])
        ->execute();

        return $row;

    }

    public function existsEstatus_aplicacionId(int $estatus_aplicacionId): bool
    {
        $query = $this->queryFactory->newSelect('estatus_aplicacion');
        $query->select('id')->where(['id' => $estatus_aplicacionId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteEstatus_aplicacionById(int $estatus_aplicacionId): void
    {
        $this->queryFactory->newDelete('estatus_aplicacion')
        ->where(['id' => $estatus_aplicacionId])
        ->execute();
    }

    private function toRow(array $estatus_aplicacion): array
    {
        
        $updated = isset($estatus_aplicacion['updated']) ? $estatus_aplicacion['updated'] : null;
        
        return [
            'estatus_aplicacion' => strtoupper($estatus_aplicacion['estatus_aplicacion'])
        ];
    }
}
