<?php

namespace App\Domain\RepresentanteLegal\Data;

/**
 * DTO.
 */
final class RepresentanteLegalReaderResult
{
    public ?int $id = null;

    public ?string $nombres = null;    
    public ?string $apellidos = null;    
    public ?string $identificacion = null;    
    public ?string $correo = null;    
    public ?int $telefono = null;    
}
