<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Data\RubrosOrigenReaderResult;
use App\Domain\RubrosOrigen\Repository\RubrosOrigenRepository;

/**
 * Service.
 */
final class RubrosOrigenReader
{
    private RubrosOrigenRepository $repository;

    /**
     * The constructor.
     *
     * @param RubrosOrigenRepository $repository The repository
     */
    public function __construct(RubrosOrigenRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a rubrosOrigen.
     *
     * @param int $rubrosOrigenId The rubrosOrigen id
     *
     * @return RubrosOrigenReaderResult The result
     */
    public function getRubrosOrigen(int $rubrosOrigenId): RubrosOrigenReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $rubrosOrigenRow = $this->repository->getRubrosOrigenById($rubrosOrigenId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RubrosOrigenReaderResult();
        $result->id = $rubrosOrigenRow['id'];
        $result->rubro = $rubrosOrigenRow['rubro'];
        $result->presentacion = $rubrosOrigenRow['presentacion'];
        $result->precio_ves = $rubrosOrigenRow['precio_ves'];
        $result->precio_ptr = $rubrosOrigenRow['precio_ptr'];
        
        return $result;
    }
}
