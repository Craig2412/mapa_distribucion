<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Data\TiposMayoristasFinderItem;
use App\Domain\TiposMayoristas\Data\TiposMayoristasFinderResult;
use App\Domain\TiposMayoristas\Repository\TiposMayoristasFinderRepository;

final class TiposMayoristasFinder
{
    private TiposMayoristasFinderRepository $repository;

    public function __construct(TiposMayoristasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTiposMayoristass(): TiposMayoristasFinderResult
    {
        // Input validation
        // ...

        $tiposMayoristass = $this->repository->findTiposMayoristass();

        return $this->createResult($tiposMayoristass);
    }

    private function createResult(array $tiposMayoristasRows): TiposMayoristasFinderResult
    {
        $result = new TiposMayoristasFinderResult();

        foreach ($tiposMayoristasRows as $tiposMayoristasRow) {
            $tiposMayoristas = new TiposMayoristasFinderItem();
            $tiposMayoristas->id = $tiposMayoristasRow['id'];
            $tiposMayoristas->tipo_mayorista = $tiposMayoristasRow['tipo_mayorista'];            

            $result->tiposMayoristass[] = $tiposMayoristas;
        }

        return $result;
    }
}
