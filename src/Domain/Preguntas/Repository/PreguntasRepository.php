<?php

namespace App\Domain\Preguntas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class PreguntasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertPreguntas(array $preguntas): int
    {
        return (int)$this->queryFactory->newInsert('preguntas', $this->toRow($preguntas))
        ->execute()
        ->lastInsertId();
    }
    
    public function getPreguntasById(int $preguntasId): array
    {
        $query = $this->queryFactory->newSelect('preguntas');
        $query->select(
            [
                'id',
                'pregunta',
                'etiqueta'
                ]
            );
            
            $query->where(['id' => $preguntasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Preguntas not found: %s', $preguntasId));
        }
        
        return $row;
    }
    
    public function updatePreguntas(int $preguntasId, array $preguntas): array
    {
        $row = $this->toRow($preguntas);
        
        $this->queryFactory->newUpdate('preguntas', $row)
        ->where(['id' => $preguntasId])
        ->execute();

        return $row;

    }

    public function existsPreguntasId(int $preguntasId): bool
    {
        $query = $this->queryFactory->newSelect('preguntas');
        $query->select('id')->where(['id' => $preguntasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deletePreguntasById(int $preguntasId): void
    {
        $this->queryFactory->newDelete('preguntas')
        ->where(['id' => $preguntasId])
        ->execute();
    }

    private function toRow(array $preguntas): array
    {
        $updated = isset($preguntas['updated']) ? $preguntas['updated'] : null;

        $para_acronimo = $preguntas['pregunta'];
        $separadas = explode(" ", $para_acronimo);
        $corto = "";
        foreach ($separadas as $primera) {
            $corto .= substr($primera, 0, 1);
        }
        
        return [
            'pregunta' => strtoupper($preguntas['pregunta']),
            'etiqueta' => strtoupper($corto)
        ];
    }
}
