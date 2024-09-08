<?php

namespace App\Domain\Encuesta\Repository;

use App\Factory\QueryFactory;

final class EncuestaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEncuestas(): array
    {
        $query = $this->queryFactory->newSelect('encuesta');

        $query->select(
            [
                'encuesta.id',
                'encuesta.id_funcionario',
                'encuesta.id_pregunta',
                'funcionarios.apellidos_nombres',
                'preguntas.pregunta',
                'encuesta.respuesta'
            ])

            ->leftjoin(['funcionarios'=>'funcionarios'], 'funcionarios.id = encuesta.id_funcionario')
            ->leftjoin(['preguntas'=>'preguntas'], 'preguntas.id = encuesta.id_pregunta');

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
