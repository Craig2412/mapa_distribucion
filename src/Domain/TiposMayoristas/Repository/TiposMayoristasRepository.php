<?php

namespace App\Domain\TiposMayoristas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TiposMayoristasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertTiposMayoristas(array $tiposMayoristas): int
    {
        return (int)$this->queryFactory->newInsert('tiposMayoristas', $this->toRow($tiposMayoristas))
        ->execute()
        ->lastInsertId();
    }
    
    public function getTiposMayoristasById(int $tiposMayoristasId): array
    {
        $query = $this->queryFactory->newSelect('tipos_mayoristas');
        $query->select(
            [
              'id',
              'tipo_mayorista'
            ]
            );
            
            $query->where(['id' => $tiposMayoristasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('TiposMayoristas not found: %s', $tiposMayoristasId));
        }
        
        return $row;
    }
    
    public function updateTiposMayoristas(int $tiposMayoristasId, array $tiposMayoristas): array
    {
        $row = $this->toRow($tiposMayoristas);
        
        $this->queryFactory->newUpdate('tiposMayoristas', $row)
        ->where(['id' => $tiposMayoristasId])
        ->execute();

        return $row;

    }

    public function existsTiposMayoristasId(int $tiposMayoristasId): bool
    {
        $query = $this->queryFactory->newSelect('tipos_mayoristas');
        $query->select('id')->where(['id' => $tiposMayoristasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteTiposMayoristasById(int $tiposMayoristasId): void
    {
        $this->queryFactory->newDelete('tiposMayoristas')
        ->where(['id' => $tiposMayoristasId])
        ->execute();
    }

    private function toRow(array $tiposMayoristas): array
    {        
        $array=[];
        foreach ($funcionarios as $key => $value) {
            $array["$key"]=strtoupper($value);
        }
        return $array;
    }
}
