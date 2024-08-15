<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalFinderItem;
use App\Domain\RepresentanteLegal\Data\RepresentanteLegalFinderResult;
use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalFinderRepository;

final class RepresentanteLegalFinder
{
    private RepresentanteLegalFinderRepository $repository;

    public function __construct(RepresentanteLegalFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRepresentanteLegals(): RepresentanteLegalFinderResult
    {
        // Input validation
        // ...

        $representanteLegals = $this->repository->findRepresentanteLegals();

        return $this->createResult($representanteLegals);
    }

    private function createResult(array $representanteLegalRows): RepresentanteLegalFinderResult
    {
        $result = new RepresentanteLegalFinderResult();

        foreach ($representanteLegalRows as $representanteLegalRow) {
            $representanteLegal = new RepresentanteLegalFinderItem();
            $representanteLegal->id = $representanteLegalRow['id'];
            $representanteLegal->nombres = $representanteLegalRow['nombres'];
            $representanteLegal->apellidos = $representanteLegalRow['apellidos'];
            $representanteLegal->identificacion = $representanteLegalRow['identificacion'];
            $representanteLegal->correo = $representanteLegalRow['correo'];
            $representanteLegal->telefono = $representanteLegalRow['telefono'];
            

            $result->representanteLegals[] = $representanteLegal;
        }

        return $result;
    }
}
