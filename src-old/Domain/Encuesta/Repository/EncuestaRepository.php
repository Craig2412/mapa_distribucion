<?php

namespace App\Domain\Encuesta\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class EncuestaRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertEncuesta(array $encuesta): int
    {
        return (int)$this->queryFactory->newInsert('encuesta', $this->toRow($encuesta))
        ->execute()
        ->lastInsertId();
    }
    
    public function getEncuestaById(int $encuestaId): array
    {
        $query = $this->queryFactory->newSelect('encuesta');
        $query->select(
            [
                'id',
                'encuesta'
                ]
            );
            
            $query->where(['id' => $encuestaId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Encuesta not found: %s', $encuestaId));
        }
        
        return $row;
    }
    
    public function updateEncuesta(int $encuestaId, array $encuesta): array
    {
        $row = $this->toRow($encuesta);
        
        $this->queryFactory->newUpdate('encuesta', $row)
        ->where(['id' => $encuestaId])
        ->execute();

        return $row;

    }

    public function existsEncuestaId(int $encuestaId): bool
    {
        $query = $this->queryFactory->newSelect('encuesta');
        $query->select('id')->where(['id' => $encuestaId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteEncuestaById(int $encuestaId): void
    {
        $this->queryFactory->newDelete('encuesta')
        ->where(['id' => $encuestaId])
        ->execute();
    }

    private function toRow(array $encuesta): array
    {
        
        $updated = isset($encuesta['updated']) ? $encuesta['updated'] : null;
        
        return [
            'id_funcionario' => strtoupper($encuesta['id_funcionario']),
            'id_pregunta' => strtoupper($encuesta['id_pregunta']),
            'respuesta' => strtoupper($encuesta['respuesta']),
            'created' => $this->fecha,
            'updated' => $updated
        ];
    }
}
