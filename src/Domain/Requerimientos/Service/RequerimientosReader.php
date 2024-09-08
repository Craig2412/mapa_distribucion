<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Data\RequerimientosReaderResult;
use App\Domain\Requerimientos\Repository\RequerimientosRepository;

/**
 * Service.
 */
final class RequerimientosReader
{
    private RequerimientosRepository $repository;

    /**
     * The constructor.
     *
     * @param RequerimientosRepository $repository The repository
     */
    public function __construct(RequerimientosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a requerimientos.
     *
     * @param int $requerimientosId The requerimientos id
     *
     * @return RequerimientosReaderResult The result
     */
    public function getRequerimientos(int $requerimientosId): RequerimientosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $requerimientosRow = $this->repository->getRequerimientosById($requerimientosId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RequerimientosReaderResult();
            
            $result->id = $requerimientosRow['id'];
            $result->agent_name = $requerimientosRow['agent_name'];
            $result->agent_lastname = $requerimientosRow['agent_lastname'];
            $result->agent_identification = $requerimientosRow['agent_identification'];
            $result->agent_rif = $requerimientosRow['agent_rif'];
            $result->agent_gender = $requerimientosRow['agent_gender'];
            $result->type_agent_name = $requerimientosRow['type_agent_name'];
            $result->agent_number_type = $requerimientosRow['agent_number_type'];
            $result->agent_telefone = $requerimientosRow['agent_telefone'];
            $result->agent_email = $requerimientosRow['agent_email'];
            $result->agent_number = $requerimientosRow['agent_number'];
            $result->direcction_name = $requerimientosRow['direcction_name'];
            $result->estado = $requerimientosRow['estado'];
            $result->municipio = $requerimientosRow['municipio'];
            $result->parroquia = $requerimientosRow['parroquia'];

        return $result;
    }
}
