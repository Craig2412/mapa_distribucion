<?php

namespace App\Domain\FormasMovilizacion\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class FormasMovilizacionRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertFormasMovilizacion(array $formasMovilizacion): int
    {
        return (int)$this->queryFactory->newInsert('formas_movilizacion_mercancia', $this->toRow($formasMovilizacion))
        ->execute()
        ->lastInsertId();
    }
    
    public function getFormasMovilizacionById(int $formasMovilizacionId): array
    {
        $query = $this->queryFactory->newSelect('formas_movilizacion_mercancia');
        $query->select(
            [
                'formas_movilizacion_mercancia.id',
                'formas_movilizacion_mercancia.id_mayorista',
                'formas_movilizacion_mercancia.id_tipo_movilizacion',
                'tipos_movilizacion.tipo_movilizacion'
            ]
            )->leftjoin(['tipos_movilizacion'=>'tipos_movilizacion'], 'tipos_movilizacion.id = formas_movilizacion_mercancia.id_tipo_movilizacion');
        $query->where(['formas_movilizacion_mercancia.id' => $id_mayorista]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('FormasMovilizacion not found: %s', $formasMovilizacionId));
        }
        
        return $row;
    }
    
    public function updateFormasMovilizacion(int $formasMovilizacionId, array $formasMovilizacion): array
    {
        $row = $this->toRow($formasMovilizacion);
        
        $this->queryFactory->newUpdate('formas_movilizacion_mercancia', $row)
        ->where(['id' => $formasMovilizacionId])
        ->execute();

        return $row;
    }

    public function existsFormasMovilizacionId(int $formasMovilizacionId): bool
    {
        $query = $this->queryFactory->newSelect('formas_movilizacion_mercancia');
        $query->select('id')->where(['id' => $formasMovilizacionId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteFormasMovilizacionById(int $formasMovilizacionId): void
    {
        $this->queryFactory->newDelete('formas_movilizacion_mercancia')
        ->where(['id' => $formasMovilizacionId])
        ->execute();
    }

    private function toRow(array $formasMovilizacion): array
    {        
        $array=[];
        foreach ($formasMovilizacion as $key => $value) {
            $array["$key"]=strtoupper($value);
        }
        return $array;
    }
}
