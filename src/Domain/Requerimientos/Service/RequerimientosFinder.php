<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Data\RequerimientosFinderItem;
use App\Domain\Requerimientos\Data\RequerimientosFinderResult;
use App\Domain\Requerimientos\Repository\RequerimientosFinderRepository;

final class RequerimientosFinder
{
    private RequerimientosFinderRepository $repository;

    public function __construct(RequerimientosFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRequerimientos($nro_pag,$where,$cant_registros): RequerimientosFinderResult
    {
        // Input validation
        $requerimientos = $this->repository->findRequerimientos($nro_pag,$where,$cant_registros);

        return $this->createResult($requerimientos);
    }

    private function createResult(array $requerimientosRows): RequerimientosFinderResult
    {
        $result = new RequerimientosFinderResult();

        foreach ($requerimientosRows as $requerimientosRow) {
            $requerimientos = new RequerimientosFinderItem();
            $requerimientos->id = $requerimientosRow['id'];
            $requerimientos->agent_name = $requerimientosRow['agent_name'];
            $requerimientos->agent_lastname = $requerimientosRow['agent_lastname'];
            $requerimientos->agent_identification = $requerimientosRow['agent_identification'];
            $requerimientos->agent_rif = $requerimientosRow['agent_rif'];
            $requerimientos->agent_gender = $requerimientosRow['agent_gender'];
            $requerimientos->agent_type = $requerimientosRow['agent_type'];
            $requerimientos->agent_number_type = $requerimientosRow['agent_number_type'];
            $requerimientos->agent_telefone = $requerimientosRow['agent_telefone'];
            $requerimientos->agent_email = $requerimientosRow['agent_email'];
            $requerimientos->agent_number = $requerimientosRow['agent_number'];
            $requerimientos->agent_estado = $requerimientosRow['agent_estado'];
            $requerimientos->created = $requerimientosRow['created'];

            $result->requerimientos[] = $requerimientos;
        }
        return $result;
    }
}
