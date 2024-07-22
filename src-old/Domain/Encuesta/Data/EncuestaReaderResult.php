<?php

namespace App\Domain\Encuesta\Data;

/**
 * DTO.
 */
final class EncuestaReaderResult
{
    public ?int $id = null;

    public ?int $id_funcionario = null;
    public ?string $nombre_funcionario = null;
    public ?int $id_pregunta = null;
    public ?string $pregunta = null;
    public ?string $respuesta = null;

    
}
