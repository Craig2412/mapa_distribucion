<?php

namespace App\Domain\Bufete\Data;

/**
 * DTO.
 */
final class BufeteReaderResult
{
    public ?int $id = null;

    public ?string $nombre_bufete = null;

    public ?string $rif = null;

    public ?string $telefono = null;
    
    public ?string $correo = null;
    
    public ?int $id_condicion = null;

    public ?string $created = null;

    public ?string $updated = null;
}