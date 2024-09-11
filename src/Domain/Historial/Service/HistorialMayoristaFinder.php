<?php

namespace App\Domain\Historial\Service;

use App\Domain\Historial\Data\HistorialMayoristaFinderItem;
use App\Domain\Historial\Data\HistorialMayoristaFinderResult;
use App\Domain\Historial\Repository\HistorialMayoristaFinderRepository;

final class HistorialMayoristaFinder
{
    private HistorialMayoristaFinderRepository $repository;

    public function __construct(HistorialMayoristaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findHistorialMayoristas(int $id_mayorista): HistorialMayoristaFinderResult
    {

        $historialMayoristas = $this->repository->findHistorialMayoristas($id_mayorista);

        return $this->createResult($historialMayoristas);
    }

    private function createResult(array $historialMayoristaRows): HistorialMayoristaFinderResult
    {
        $result = new HistorialMayoristaFinderResult();

        foreach ($historialMayoristaRows as $historialMayoristaRow) {
            $historialMayorista = new HistorialMayoristaFinderItem();
            $historialMayorista->id = $historialMayoristaRow['id'];
            $historialMayorista->id_mayorista = $historialMayoristaRow['id_mayorista'];
            $historialMayorista->campo = $historialMayoristaRow['campo'];
            $historialMayorista->dato_nuevo = $historialMayoristaRow['dato_nuevo'];
            $historialMayorista->fecha = $historialMayoristaRow['fecha'];
            
            $result->historialMayoristas[] = $historialMayorista;
        }

        return $result;
    }
}
