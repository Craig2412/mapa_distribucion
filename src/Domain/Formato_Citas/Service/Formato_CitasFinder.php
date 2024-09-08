<?php

namespace App\Domain\Formato_Citas\Service;

use App\Domain\Formato_Citas\Data\Formato_CitasFinderItem;
use App\Domain\Formato_Citas\Data\Formato_CitasFinderResult;
use App\Domain\Formato_Citas\Repository\Formato_CitasFinderRepository;

final class Formato_CitasFinder
{
    private Formato_CitasFinderRepository $repository;

    public function __construct(Formato_CitasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFormato_Citass(): Formato_CitasFinderResult
    {
        // Input validation
        // ...

        $formato_citass = $this->repository->findFormato_Citass();

        return $this->createResult($formato_citass);
    }

    private function createResult(array $formato_citasRows): Formato_CitasFinderResult
    {
        $result = new Formato_CitasFinderResult();

        foreach ($formato_citasRows as $formato_citasRow) {
            $formato_citas = new Formato_CitasFinderItem();
            $formato_citas->id = $formato_citasRow['id'];
            $formato_citas->formato_cita = $formato_citasRow['formato_cita'];
           
            $result->formato_citass[] = $formato_citas;
        }

        return $result;
    }
}
