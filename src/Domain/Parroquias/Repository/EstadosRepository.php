<?php

namespace App\Domain\Estatus\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class EstatusRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertEstatus(array $estatus): int
    {
        return (int)$this->queryFactory->newInsert('estatus', $this->toRow($estatus))
        ->execute()
        ->lastInsertId();
    }
    
    public function getEstatusById(int $estatusId): array
    {
        $query = $this->queryFactory->newSelect('estatus');
        $query->select(
            [
                'id',
                'estatus'
                ]
            );
            
            $query->where(['id' => $estatusId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Estatus not found: %s', $estatusId));
        }
        
        return $row;
    }
    
    public function updateEstatus(int $estatusId, array $estatus): array
    {
        $row = $this->toRow($estatus);
        
        $this->queryFactory->newUpdate('estatus', $row)
        ->where(['id' => $estatusId])
        ->execute();

        return $row;

    }

    public function existsEstatusId(int $estatusId): bool
    {
        $query = $this->queryFactory->newSelect('estatus');
        $query->select('id')->where(['id' => $estatusId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteEstatusById(int $estatusId): void
    {
        $this->queryFactory->newDelete('estatus')
        ->where(['id' => $estatusId])
        ->execute();
    }

    private function toRow(array $estatus): array
    {
        
        $updated = isset($estatus['updated']) ? $estatus['updated'] : null;
        
        return [
            'estatus' => strtoupper($estatus['estatus'])
        ];
    }
}
