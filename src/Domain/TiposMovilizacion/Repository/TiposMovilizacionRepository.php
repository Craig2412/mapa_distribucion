<?php

namespace App\Domain\TiposMovilizacion\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TiposMovilizacionRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertTiposMovilizacion(array $tiposMovilizacion): int
    {
        return (int)$this->queryFactory->newInsert('tipos_movilizacion', $this->toRow($tiposMovilizacion))
        ->execute()
        ->lastInsertId();
    }
    
    public function getTiposMovilizacionById(int $tiposMovilizacionId): array
    {
        $query = $this->queryFactory->newSelect('tipos_movilizacion');
        $query->select(
                [
                    'id',
                    'tipo_movilizacion'
                ]
            );
            
            $query->where(['id' => $tiposMovilizacionId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('TiposMovilizacion not found: %s', $tiposMovilizacionId));
        }
        
        return $row;
    }
    
    public function updateTiposMovilizacion(int $tiposMovilizacionId, array $tiposMovilizacion): array
    {
        $row = $this->toRow($tiposMovilizacion);
        
        $this->queryFactory->newUpdate('tipos_movilizacion', $row)
        ->where(['id' => $tiposMovilizacionId])
        ->execute();

        return $row;
    }

    public function existsTiposMovilizacionId(int $tiposMovilizacionId): bool
    {
        $query = $this->queryFactory->newSelect('tipos_movilizacion');
        $query->select('id')->where(['id' => $tiposMovilizacionId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteTiposMovilizacionById(int $tiposMovilizacionId): void
    {
        $this->queryFactory->newDelete('tipos_movilizacion')
        ->where(['id' => $tiposMovilizacionId])
        ->execute();
    }

    private function toRow(array $tiposMovilizacion): array
    {        
        $array=[];
        foreach ($tiposMovilizacion as $key => $value) {
            $array["$key"]=strtoupper($value);
        }
        return $array;
    }
}
