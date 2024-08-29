<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Data\TiposMovilizacionReaderResult;
use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionRepository;

/**
 * Service.
 */
final class TiposMovilizacionReader
{
    private TiposMovilizacionRepository $repository;

    /**
     * The constructor.
     *
     * @param TiposMovilizacionRepository $repository The repository
     */
    public function __construct(TiposMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a tiposMovilizacion.
     *
     * @param int $tiposMovilizacionId The tiposMovilizacion id
     *
     * @return TiposMovilizacionReaderResult The result
     */
    public function getTiposMovilizacion(int $tiposMovilizacionId): TiposMovilizacionReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $tiposMovilizacionRow = $this->repository->getTiposMovilizacionById($tiposMovilizacionId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new TiposMovilizacionReaderResult();
        $result->id = $tiposMovilizacionRow['id'];
        $result->tipo_movilizacion = $tiposMovilizacionRow['tipo_movilizacion'];
        
        return $result;
    }
}
