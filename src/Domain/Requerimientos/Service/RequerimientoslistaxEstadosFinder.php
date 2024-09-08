<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Data\RequerimientoslistaxEstadosFinderItem;
use App\Domain\Requerimientos\Data\RequerimientoslistaxEstadosFinderResult;
use App\Domain\Requerimientos\Repository\RequerimientoslistaxEstadosFinderRepository;

final class RequerimientoslistaxEstadosFinder
{
    private RequerimientoslistaxEstadosFinderRepository $repository;

    public function __construct(RequerimientoslistaxEstadosFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRequerimientoslistaxEstados(): RequerimientoslistaxEstadosFinderResult
    {
        // Input validation
        $requerimientoslistaxEstados = $this->repository->findRequerimientoslistaxEstados();

        return $this->createResult($requerimientoslistaxEstados);
    }

    private function createResult(array $requerimientoslistaxEstadosRows): RequerimientoslistaxEstadosFinderResult
    {
        $result = new RequerimientoslistaxEstadosFinderResult();
        
        foreach ($requerimientoslistaxEstadosRows as $requerimientoslistaxEstadosRow) {
            $requerimientoslistaxEstados = new RequerimientoslistaxEstadosFinderItem();
           
            $requerimientos->id = $requerimientosRow['id'];
            $requerimientos->id_formato_cita = $requerimientosRow['id_formato_cita'];
            $requerimientos->formato_cita = $requerimientosRow['formato_cita'];
            $requerimientos->id_estado = $requerimientosRow['id_estado'];
            $requerimientos->id_condicion = $requerimientosRow['id_condicion'];
            $requerimientos->id_usuario = $requerimientosRow['id_usuario'];
            $requerimientos->nombre = $requerimientosRow['nombre'];
            $requerimientos->apellido = $requerimientosRow['apellido'];
            $requerimientos->name = $requerimientosRow['name'];
            $requerimientos->identificacion = $requerimientosRow['identificacion'];
            $requerimientos->id_pais = $requerimientosRow['id_pais'];
            $requerimientos->pais = $requerimientosRow['pais'];
            $requerimientos->id_estado_pais = $requerimientosRow['id_estado_pais'];
            $requerimientos->estado_pais = $requerimientosRow['estado_pais'];
            $requerimientos->id_trabajador = $requerimientosRow['id_trabajador'];
            $requerimientos->trabajador = $requerimientosRow['trabajador'];
            $requerimientos->estado = $requerimientosRow['estado'];
            $requerimientos->created = $requerimientosRow['created'];
            $requerimientos->updated = $requerimientosRow['updated'];

            $result->requerimientoslistaxEstados[] = $requerimientoslistaxEstados;
        }
        
        return $result;
    }
}
