<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Data\CitaFinderItem;
use App\Domain\Cita\Data\CitaFinderResult;
use App\Domain\Cita\Repository\CitaFinderRepository;

final class CitaFinder
{
    private CitaFinderRepository $repository;

    public function __construct(CitaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCita($nro_pag,$parametros,$cant_registros): CitaFinderResult
    {

        $cita = $this->repository->findCita($nro_pag,$parametros,$cant_registros);

        return $this->createResult($cita);
    }

    private function createResult(array $citasRows): CitaFinderResult
    {
        $result = new CitaFinderResult();

        foreach ($citasRows as $citasRow) {
            $citas = new CitaFinderItem();
            $citas->id = $citasRow['id'];
            $citas->fecha_cita = $citasRow['fecha_cita'];
            $citas->id_requerimiento = $citasRow['id_requerimiento'];
            $citas->estado = $citasRow['estado'];
            $citas->nombre = $citasRow['nombre'].' '.$citasRow['apellido'];
            $citas->id_estado = $citasRow['id_estado'];
            $citas->id_formato_cita = $citasRow['id_formato_cita'];
            $citas->formato_cita = $citasRow['formato_cita'];
            $citas->id_condicion = $citasRow['id_condicion'];
            $citas->created = $citasRow['created'];
            $citas->updated = $citasRow['updated'];

            $result->cita[] = $citas;
        }
      
        return $result;
    }
}
