<?php

namespace App\Domain\Imagenes\Repository;

use App\Factory\QueryFactory;

final class ImagenesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findImageness(): array
    {
        $query = $this->queryFactory->newSelect('imagenes');

        $query->select(
            [
                'id',
                'url'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
