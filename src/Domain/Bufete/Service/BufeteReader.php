<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Data\BufeteReaderResult;
use App\Domain\Bufete\Repository\BufeteRepository;

/**
 * Service.
 */
final class BufeteReader
{
    private BufeteRepository $repository;

    /**
     * The constructor.
     *
     * @param BufeteRepository $repository The repository
     */
    public function __construct(BufeteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a bufete.
     *
     * @param int $bufeteId The bufete id
     *
     * @return BufeteReaderResult The result
     */
    public function getBufete(int $bufeteId): BufeteReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $bufeteRow = $this->repository->getBufeteById($bufeteId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new BufeteReaderResult();
        $result->id = $bufeteRow['id'];
        $result->correo = $bufeteRow['correo'];
        $result->telefono = $bufeteRow['telefono'];
        $result->rif = $bufeteRow['rif'];
        $result->nombre_bufete = $bufeteRow['nombre_bufete'];
        
        $result->id_condicion = $bufeteRow['id_condicion'];
        $result->created = $bufeteRow['created'];
        $result->updated = $bufeteRow['updated'];

        return $result;
    }
}
