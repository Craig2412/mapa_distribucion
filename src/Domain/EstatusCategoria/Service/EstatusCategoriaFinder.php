<?php

namespace App\Domain\EstatusCategoria\Service;

use App\Domain\EstatusCategoria\Data\EstatusCategoriaFinderItem;
use App\Domain\EstatusCategoria\Data\EstatusCategoriaFinderResult;
use App\Domain\EstatusCategoria\Repository\EstatusCategoriaFinderRepository;

final class EstatusCategoriaFinder
{
    private EstatusCategoriaFinderRepository $repository;

    public function __construct(EstatusCategoriaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEstatusCategorias(): EstatusCategoriaFinderResult
    {
        // Input validation
        // ...

        $estatusCategoriass = $this->repository->findEstatusCategorias();

        return $this->createResult($estatusCategoriass);
    }

    private function createResult(array $estatusCategoriasRows): EstatusCategoriaFinderResult
    {
        $result = new EstatusCategoriaFinderResult();

        foreach ($estatusCategoriasRows as $estatusCategoriasRow) {
            $estatusCategorias = new EstatusCategoriaFinderItem();
            $estatusCategorias->id = $estatusCategoriasRow['id'];
            $estatusCategorias->id_categoria = $estatusCategoriasRow['id_categoria'];
            $estatusCategorias->categoria = $estatusCategoriasRow['categoria'];
            $estatusCategorias->created = $estatusCategoriasRow['created'];
            $estatusCategorias->updated = $estatusCategoriasRow['updated'];
            $estatusCategorias->estatusCategoria = $estatusCategoriasRow['estatus_categoria'];
           
            $result->estatusCategoriass[] = $estatusCategorias;
        }

        return $result;
    }
}
