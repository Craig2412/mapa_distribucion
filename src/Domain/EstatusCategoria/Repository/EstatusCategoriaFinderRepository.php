<?php

namespace App\Domain\EstatusCategoria\Repository;

use App\Factory\QueryFactory;

final class EstatusCategoriaFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEstatusCategorias(): array
    {
        $query = $this->queryFactory->newSelect('estatus_categorias');

        $query->select(
            [
                'estatus_categorias.id',
                'estatus_categorias.estatus_categoria',
                'estatus_categorias.id_categoria',
                'categorias.categoria',
                'estatus_categorias.created',
                'estatus_categorias.updated'
            ]

        )
        ->leftjoin(['categorias'=>'categorias'], 'categorias.id = estatus_categorias.id_categoria');
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
