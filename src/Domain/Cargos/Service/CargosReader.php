<?php

namespace App\Domain\Cargos\Service;

use App\Domain\Cargos\Data\CargosReaderResult;
use App\Domain\Cargos\Repository\CargosRepository;

/**
 * Service.
 */
final class CargosReader
{
    private CargosRepository $repository;

    /**
     * The constructor.
     *
     * @param CargosRepository $repository The repository
     */
    public function __construct(CargosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a cargos.
     *
     * @param int $cargosId The cargos id
     *
     * @return CargosReaderResult The result
     */
    public function getCargos(int $cargosId): CargosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $cargosRow = $this->repository->getCargosById($cargosId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new CargosReaderResult();
        $result->id = $cargosRow['id'];
        $result->cargo = $cargosRow['charge'];

        return $result;
    }
}
