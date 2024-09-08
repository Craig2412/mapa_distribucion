<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Data\MensajeReaderResult;
use App\Domain\Mensaje\Data\MensajeFinderResult;
use App\Domain\Mensaje\Repository\MensajeRepository;

/**
 * Service.
 */
final class MensajeReader
{
    private MensajeRepository $repository;

    /**
     * The constructor.
     *
     * @param MensajeRepository $repository The repository
     */
    public function __construct(MensajeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a mensaje.
     *
     * @param int $mensajeId The mensaje id
     *
     * @return MensajeFinderResult The result
     */
    public function getMensaje(int $mensajeId): MensajeFinderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $mensajeRows = $this->repository->getMensajeById($mensajeId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result

        $array = new MensajeFinderResult();

        foreach ($mensajeRows as $mensajeRow) {
            $result = new MensajeReaderResult();
            $result->area_name = $mensajeRow['area_name'];
            $result->val = $mensajeRow['val'];

            $array->mensajes[] = $result;
        }
        return $array;
    }
}
