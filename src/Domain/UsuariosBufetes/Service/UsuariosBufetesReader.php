<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Data\UsuariosBufetesReaderResult;
use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesRepository;

/**
 * Service.
 */
final class UsuariosBufetesReader
{
    private UsuariosBufetesRepository $repository;

    /**
     * The constructor.
     *
     * @param UsuariosBufetesRepository $repository The repository
     */
    public function __construct(UsuariosBufetesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a usuariosbufete.
     *
     * @param int $usuariosbufeteId The usuariosbufete id
     *
     * @return UsuariosBufetesReaderResult The result
     */
    public function getUsuariosBufetes(int $usuariosbufeteId): UsuariosBufetesReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $usuariosbufeteRow = $this->repository->getUsuariosBufetesById($usuariosbufeteId);
        
        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new UsuariosBufetesReaderResult();
        $result->id = $usuariosbufeteRow['id'];
        $result->nombre = $usuariosbufeteRow['nombre'];
        $result->id_usuario = $usuariosbufeteRow['id_usuario'];
        $result->bufete = $usuariosbufeteRow['nombre_bufete'];
        $result->id_bufete = $usuariosbufeteRow['id_bufete'];
        
        return $result;
    }
}