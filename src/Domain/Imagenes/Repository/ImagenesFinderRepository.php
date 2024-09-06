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

    public function findImageness(int $id_mayorista): array
    {
        $query = $this->queryFactory->newSelect('img_mayorista');

        $query->select(
            [
                'img_mayorista.id',
                'img_mayorista.id_img',
                'img_mayorista.id_mayorista',
                'imagenes.url'
            ]
        )->leftjoin(['imagenes'=>'imagenes'], 'imagenes.id = img_mayorista.id_img');

        $query->where(['img_mayorista.id_mayorista' => $id_mayorista]);

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
