<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalReaderResult;
use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;

/**
 * Service.
 */
final class RepresentanteLegalbyCedulaReader
{
    private RepresentanteLegalRepository $repository;

    /**
     * The constructor.
     *
     * @param RepresentanteLegalRepository $repository The repository
     */
    public function __construct(RepresentanteLegalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a representanteLegalbyCedula.
     *
     * @param int $representanteLegalbyCedulaId The representanteLegalbyCedula id
     *
     * @return RepresentanteLegalReaderResult The result
     */
    public function getRepresentanteLegalbyCedula(string $representanteLegalbyCedulaId): RepresentanteLegalReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $representanteLegalbyCedulaRow = $this->repository->getRepresentanteLegalbyCedulaById($representanteLegalbyCedulaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RepresentanteLegalReaderResult();
        $result->id = $representanteLegalbyCedulaRow['id'];
        $result->nombres = $representanteLegalbyCedulaRow['nombres'];
        $result->apellidos = $representanteLegalbyCedulaRow['apellidos'];
        $result->identificacion = $representanteLegalbyCedulaRow['identificacion'];
        $result->correo = $representanteLegalbyCedulaRow['correo'];
        $result->telefono = $representanteLegalbyCedulaRow['telefono'];
        
        return $result;
    }
}
