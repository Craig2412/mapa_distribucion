<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Data\TiposMovilizacionFinderItem;
use App\Domain\TiposMovilizacion\Data\TiposMovilizacionFinderResult;
use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionFinderRepository;

final class TiposMovilizacionFinder
{
    private TiposMovilizacionFinderRepository $repository;

    public function __construct(TiposMovilizacionFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTiposMovilizacions(): TiposMovilizacionFinderResult
    {
        // Input validation
        // ...

        $tiposMovilizacions = $this->repository->findTiposMovilizacions();

        return $this->createResult($tiposMovilizacions);
    }

    private function createResult(array $tiposMovilizacionRows): TiposMovilizacionFinderResult
    {
        $result = new TiposMovilizacionFinderResult();

        foreach ($tiposMovilizacionRows as $tiposMovilizacionRow) {
            $tiposMovilizacion = new TiposMovilizacionFinderItem();
            $tiposMovilizacion->id = $tiposMovilizacionRow['id'];
            $tiposMovilizacion->tipo_movilizacion = $tiposMovilizacionRow['tipo_movilizacion'];            

            $result->tiposMovilizacions[] = $tiposMovilizacion;
        }

        return $result;
    }
}
