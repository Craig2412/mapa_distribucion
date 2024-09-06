<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Data\RubrosReaderResult;
use App\Domain\Rubros\Repository\RubrosRepository;

/**
 * Service.
 */
final class RubrosReader
{
    private RubrosRepository $repository;

    /**
     * The constructor.
     *
     * @param RubrosRepository $repository The repository
     */
    public function __construct(RubrosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a rubros.
     *
     * @param int $rubrosId The rubros id
     *
     * @return RubrosReaderResult The result
     */
    public function getRubros(int $rubrosId): RubrosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $rubrosRow = $this->repository->getRubrosById($rubrosId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RubrosReaderResult();
        $result->id = $rubrosRow['id'];
        $result->rubro = $rubrosRow['rubro'];
        $result->presentacion = $rubrosRow['presentacion'];
        $result->precio_ves = $rubrosRow['precio_ves'];
        $result->precio_ptr = $rubrosRow['precio_ptr'];
        
        return $result;
    }
}
