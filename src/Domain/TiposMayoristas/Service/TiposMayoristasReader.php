<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Data\TiposMayoristasReaderResult;
use App\Domain\TiposMayoristas\Repository\TiposMayoristasRepository;

/**
 * Service.
 */
final class TiposMayoristasReader
{
    private TiposMayoristasRepository $repository;

    /**
     * The constructor.
     *
     * @param TiposMayoristasRepository $repository The repository
     */
    public function __construct(TiposMayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a tiposMayoristas.
     *
     * @param int $tiposMayoristasId The tiposMayoristas id
     *
     * @return TiposMayoristasReaderResult The result
     */
    public function getTiposMayoristas(int $tiposMayoristasId): TiposMayoristasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $tiposMayoristasRow = $this->repository->getTiposMayoristasById($tiposMayoristasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new TiposMayoristasReaderResult();
        $result->id = $tiposMayoristasRow['id'];
        $result->tipo_mayorista = $tiposMayoristasRow['tipo_mayorista'];
        
        return $result;
    }
}
