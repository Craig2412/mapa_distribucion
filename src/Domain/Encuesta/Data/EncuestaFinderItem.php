<?php

namespace App\Domain\Encuesta\Data;

/**
 * DTO.
 */
final class EncuestaFinderItem
{
    public ?int $id = null;
    public ?int $id_funcionario = null;
    public ?string $funcionario = null;
    public ?int $id_pregunta = null;
    public ?string $pregunta = null;
    public ?string $respuesta = null;
}


