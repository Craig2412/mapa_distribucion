<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Data\UsuariosBufetesFinderItem;
use App\Domain\UsuariosBufetes\Data\UsuariosBufetesFinderResult;
use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesFinderRepository;

final class UsuariosBufetesFinder
{
    private UsuariosBufetesFinderRepository $repository;

    public function __construct(UsuariosBufetesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findUsuariosBufetes(): UsuariosBufetesFinderResult
    {
        // Input validation
        // ...

        $usuariosbufetes = $this->repository->findUsuariosBufetes();

        return $this->createResult($usuariosbufetes);
    }

    private function createResult(array $usuariosbufetesRows): UsuariosBufetesFinderResult
    {
        $result = new UsuariosBufetesFinderResult();

        foreach ($usuariosbufetesRows as $usuariosbufetesRow) {
            $usuariosbufetes = new UsuariosBufetesFinderItem();
            
            $usuariosbufetes->id = $usuariosbufetesRow['id'];
            $usuariosbufetes->id_bufete = $usuariosbufetesRow['id_bufete'];
            $usuariosbufetes->id_usuario = $usuariosbufetesRow['id_usuario'];
            $usuariosbufetes->nombre = $usuariosbufetesRow['nombre'];
            $usuariosbufetes->bufete = $usuariosbufetesRow['nombre_bufete'];

            $result->usuariosbufetes[] = $usuariosbufetes;
        }

        return $result;
    }
}
