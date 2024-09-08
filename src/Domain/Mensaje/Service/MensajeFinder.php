<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Data\MensajeFinderItem;
use App\Domain\Mensaje\Data\MensajeFinderResult;
use App\Domain\Mensaje\Repository\MensajeFinderRepository;

final class MensajeFinder
{
    private MensajeFinderRepository $repository;

    public function __construct(MensajeFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findMensaje($nro_pag,$where,$cant_registros,$solicitudId): MensajeFinderResult
    {
        // Input validation
        $mensaje = $this->repository->findMensaje($nro_pag,$where,$cant_registros,$solicitudId);

        return $this->createResult($mensaje);
    }

    private function createResult(array $mensajeRows): MensajeFinderResult
    {
        $result = new MensajeFinderResult();

        foreach ($mensajeRows as $mensajeRow) {
            $mensaje = new MensajeFinderItem();
           
            $mensaje->id = $mensajeRow['id'];
            $mensaje->mensaje = $mensajeRow['mensaje'];
            $mensaje->id_usuario = $mensajeRow['id_usuario'];
            $mensaje->nombre = $mensajeRow['nombre'];
            $mensaje->apellido = $mensajeRow['apellido'];
            $mensaje->id_solicitud = $mensajeRow['id_solicitud'];
            $mensaje->id_condicion = $mensajeRow['id_condicion'];
            $mensaje->created = $mensajeRow['created'];
            $mensaje->updated = $mensajeRow['updated'];

            $result->mensaje[] = $mensaje;
        }

        return $result;
    }
}
