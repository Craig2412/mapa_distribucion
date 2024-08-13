<?php

namespace App\Domain\Rubros\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RubrosRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertRubros(array $rubros): int
    {
        return (int)$this->queryFactory->newInsert('rubros', $this->toRow($rubros))
        ->execute()
        ->lastInsertId();
    }
    
    public function getRubrosById(int $rubrosId): array
    {
        $query = $this->queryFactory->newSelect('rubros');
        $query->select(
            [
                'id',
                'rubro',
                'presentacion',
                'precio_ves',
                'precio_ptr'
                ]
            );
            
            $query->where(['id' => $rubrosId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Rubros not found: %s', $rubrosId));
        }
        
        return $row;
    }
    
    public function updateRubros(int $rubrosId, array $rubros): array
    {
        $row = $this->toRow($rubros);
        
        $this->queryFactory->newUpdate('rubros', $row)
        ->where(['id' => $rubrosId])
        ->execute();

        return $row;

    }

    public function existsRubrosId(int $rubrosId): bool
    {
        $query = $this->queryFactory->newSelect('rubros');
        $query->select('id')->where(['id' => $rubrosId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteRubrosById(int $rubrosId): void
    {
        $this->queryFactory->newDelete('rubros')
        ->where(['id' => $rubrosId])
        ->execute();
    }

    private function toRow(array $rubros): array
    {
        
        $updated = isset($rubros['updated']) ? $rubros['updated'] : null;
        
        return [
            'rubro' => strtoupper($rubros['rubro']),
            'presentacion' => strtoupper($rubros['presentacion']),
            'precio_ves' => strtoupper($rubros['precio_ves']),
            'precio_ptr' => strtoupper($rubros['precio_ptr'])
        ];
    }
}
