<?php

namespace App\Domain\Cita\Data;

final class CitaReaderResult
{
    public ?int $id = null;

    public ?string $fecha_cita = null;

    public ?int $id_requerimiento = null;

    public ?int $id_usuario = null;
    
    public ?string $nombre = null;

    public ?string $estado = null;

    public ?int $id_estado = null;

    public ?int $id_formato_cita = null;

    public ?int $id_condicion = null;

    public ?string $formato_cita = null;

    public ?string $created = null;

    public ?string $updated = null;

}