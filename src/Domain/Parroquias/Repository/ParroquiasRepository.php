<?php

namespace App\Domain\Parroquias\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class ParroquiasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertParroquias(array $parroquias): int
    {
        return (int)$this->queryFactory->newInsert('parroquias', $this->toRow($parroquias))
        ->execute()
        ->lastInsertId();
    }
    
    public function getParroquiasById(int $parroquiasId): array
    {
        $query = $this->queryFactory->newSelect('parroquias');
        $query->select(
            [
                'id',
                'parroquia'
                ]
            );
            
            $query->where(['id' => $parroquiasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Parroquias not found: %s', $parroquiasId));
        }
        
        return $row;
    }
    
    public function updateParroquias(int $parroquiasId, array $parroquias): array
    {
        $row = $this->toRow($parroquias);
        
        $this->queryFactory->newUpdate('parroquias', $row)
        ->where(['id' => $parroquiasId])
        ->execute();

        return $row;

    }

    public function existsParroquiasId(int $parroquiasId): bool
    {
        $query = $this->queryFactory->newSelect('parroquias');
        $query->select('id')->where(['id' => $parroquiasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteParroquiasById(int $parroquiasId): void
    {
        $this->queryFactory->newDelete('parroquias')
        ->where(['id' => $parroquiasId])
        ->execute();
    }

    private function toRow(array $parroquias): array
    {
        
        $updated = isset($parroquias['updated']) ? $parroquias['updated'] : null;
        
        return [
            'parroquias' => strtoupper($parroquias['parroquias'])
        ];
    }
}
