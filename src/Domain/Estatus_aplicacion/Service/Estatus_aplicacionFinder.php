<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Data\Estatus_aplicacionFinderItem;
use App\Domain\Estatus_aplicacion\Data\Estatus_aplicacionFinderResult;
use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionFinderRepository;

final class Estatus_aplicacionFinder
{
    private Estatus_aplicacionFinderRepository $repository;

    public function __construct(Estatus_aplicacionFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEstatus_aplicacions(): Estatus_aplicacionFinderResult
    {
        // Input validation
        // ...

        $estatus_aplicacions = $this->repository->findEstatus_aplicacions();

        return $this->createResult($estatus_aplicacions);
    }

    private function createResult(array $estatus_aplicacionRows): Estatus_aplicacionFinderResult
    {
        $result = new Estatus_aplicacionFinderResult();

        foreach ($estatus_aplicacionRows as $estatus_aplicacionRow) {
            $estatus_aplicacion = new Estatus_aplicacionFinderItem();
            $estatus_aplicacion->id = $estatus_aplicacionRow['id'];
            $estatus_aplicacion->estatus_aplicacion = $estatus_aplicacionRow['estatus_aplicacion'];
            

            $result->estatus_aplicacions[] = $estatus_aplicacion;
        }
        //var_dump($result);

        return $result;
    }
}
