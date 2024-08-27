<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Data\CitaFinderItem;
use App\Domain\Cita\Data\CitaFinderResult;
use App\Domain\Cita\Repository\CitaCalendarioFinderRepository;

final class CitaCalendarioFinder
{
    private CitaCalendarioFinderRepository $repository;

    public function __construct(CitaCalendarioFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCitaCalendario($nro_pag,$cant_registros,$fecha_inicial,$fecha_final): CitaFinderResult
    {
        // Input validation
        $citaCalendario = $this->repository->findCitaCalendario($nro_pag,$cant_registros,$fecha_inicial,$fecha_final);

        return $this->createResult($citaCalendario);
    }

    private function createResult(array $citaCalendarioRows): CitaFinderResult
    {
        $result = new CitaFinderResult();

        foreach ($citaCalendarioRows as $citaCalendarioRow) {
                        
            $citaCalendario = new CitaFinderItem();
            $citaCalendario->id = $citaCalendarioRow['id'];
            $citaCalendario->fecha_cita = $citaCalendarioRow['fecha_cita'];
            $citaCalendario->id_requerimiento = $citaCalendarioRow['id_requerimiento'];
            $citaCalendario->id_usuario = $citaCalendarioRow['id_usuario'];
            $citaCalendario->nombre = $citaCalendarioRow['nombre'];
            $citaCalendario->estado = $citaCalendarioRow['estado'];
            $citaCalendario->id_estado = $citaCalendarioRow['id_estado'];
            $citaCalendario->id_formato_cita = $citaCalendarioRow['id_formato_cita'];
            $citaCalendario->formato_cita = $citaCalendarioRow['formato_cita'];
            $citaCalendario->id_condicion = $citaCalendarioRow['id_condicion'];
            $citaCalendario->created = $citaCalendarioRow['created'];
            $citaCalendario->updated = $citaCalendarioRow['updated'];
            

            $result->citaCalendario[] = $citaCalendario;
        }
        
        return $result;
    }
}
