<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Data\UsuarioReaderResult;
use App\Domain\Usuario\Repository\UsuarioRepository;

/**
 * Service.
 */
final class UsuarioReader
{
    private UsuarioRepository $repository;

    /**
     * The constructor.
     *
     * @param UsuarioRepository $repository The repository
     */
    public function __construct(UsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a usuario.
     *
     * @param int $usuarioId The usuario id
     *
     * @return UsuarioReaderResult The result
     */
    public function getUsuario(int $usuarioId): UsuarioReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $usuarioRow = $this->repository->getUsuarioById($usuarioId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new UsuarioReaderResult();
        $result->id = $usuarioRow['id'];
        $result->name = $usuarioRow['name'];
        $result->identification = $usuarioRow['identification'];
        $result->email = $usuarioRow['email'];
        $result->id_role = $usuarioRow['id_role'];
        $result->role = $usuarioRow['role'];
        $result->created = $usuarioRow['created'];
        $result->updated = $usuarioRow['updated'];
        
        return $result;
    }
}
