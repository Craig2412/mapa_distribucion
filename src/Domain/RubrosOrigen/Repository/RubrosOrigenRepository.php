<?php

namespace App\Domain\RubrosOrigen\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RubrosOrigenRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertRubrosOrigen(array $rubrosOrigen): int
    {
        return (int)$this->queryFactory->newInsert('origenes_productos', $this->toRow($rubrosOrigen))
        ->execute()
        ->lastInsertId();
    }
    
    public function getRubrosOrigenById(int $rubrosOrigenId): array
    {
        $query = $this->queryFactory->newSelect('origenes_productos');
        $query->select(
            [
                'id',
                'importacion',
                'origen_especifico'
                ]
            );
            
            $query->where(['id' => $rubrosOrigenId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('RubrosOrigen not found: %s', $rubrosOrigenId));
        }
        
        return $row;
    }
    
    public function updateRubrosOrigen(int $rubrosOrigenId, array $rubrosOrigen): array
    {
        $row = $this->toRowUpdate($rubrosOrigen);
        
        $this->queryFactory->newUpdate('origenes_productos', $row)
        ->where(['id' => $rubrosOrigenId])
        ->execute();

        return $row;

    }

    public function existsRubrosOrigenId(int $rubrosOrigenId): bool
    {
        $query = $this->queryFactory->newSelect('origenes_productos');
        $query->select('id')->where(['id' => $rubrosOrigenId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteRubrosOrigenById(int $rubrosOrigenId): void
    {
        $this->queryFactory->newDelete('origenes_productos')
        ->where(['id' => $rubrosOrigenId])
        ->execute();
    }

    private function toRow(array $rubrosOrigen): array
    {        
        $updated = isset($rubrosOrigen['updated']) ? $rubrosOrigen['updated'] : null;
        
        return [
            'rubro' => strtoupper($rubrosOrigen['rubro']),
            'presentacion' => strtoupper($rubrosOrigen['presentacion']),
            'precio_ves' => $rubrosOrigen['precio_ves'],
            'precio_ptr' => $rubrosOrigen['precio_ptr']
        ];
    }

    private function toRowUpdate(array $funcionarios): array
    {
        $updated = isset($funcionarios['updated']) ? $funcionarios['updated'] : null;
        
        $array=[];
        foreach ($funcionarios as $key => $value) {
            $array["$key"]=strtoupper($value);
        }
        return $array;
    }
}
