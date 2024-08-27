<?php

namespace App\Domain\Categorias\Repository;

use App\Factory\QueryFactory;

final class CategoriasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCategorias(): array
    {
        $query = $this->queryFactory->newSelect('categorias');

        $query->select(
            [
                'categorias.id',
                'categorias.categoria',
                'categorias.id_condicion',
                'categorias.id_departamento',
                'departamento.departamento',
                'categorias.created',
                'categorias.updated'
            ]
        )->leftjoin(['departamento'=>'departamentos'],'departamento.id = categorias.id_departamento');

        $query->where(['categorias.id_condicion' => 1]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
