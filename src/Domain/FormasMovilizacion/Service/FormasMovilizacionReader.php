<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Data\FormasMovilizacionReaderResult;
use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionRepository;

/**
 * Service.
 */
final class FormasMovilizacionReader
{
    private FormasMovilizacionRepository $repository;

    /**
     * The constructor.
     *
     * @param FormasMovilizacionRepository $repository The repository
     */
    public function __construct(FormasMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a formasMovilizacion.
     *
     * @param int $formasMovilizacionId The formasMovilizacion id
     *
     * @return FormasMovilizacionReaderResult The result
     */
    public function getFormasMovilizacion(int $formasMovilizacionId): FormasMovilizacionReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $formasMovilizacionRow = $this->repository->getFormasMovilizacionById($formasMovilizacionId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new FormasMovilizacionReaderResult();
        $result->id = $formasMovilizacionRow['id'];
        $result->id_mayorista = $formasMovilizacionRow['id_mayorista'];
        $result->id_tipo_movilizacion = $formasMovilizacionRow['id_tipo_movilizacion'];
        $result->tipo_movilizacions = $formasMovilizacionRow['tipo_movilizacions'];
        
        return $result;
    }
}
