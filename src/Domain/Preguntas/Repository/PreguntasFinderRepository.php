<?php

namespace App\Domain\Preguntas\Repository;

use App\Factory\QueryFactory;

final class PreguntasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findPreguntass(): array
    {
        $query = $this->queryFactory->newSelect('preguntas');

        $query->select(
            [
                'id',
                'pregunta',
                'etiqueta'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
