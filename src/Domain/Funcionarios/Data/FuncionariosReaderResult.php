<?php

namespace App\Domain\Funcionarios\Data;

/**
 * DTO.
 */
final class FuncionariosReaderResult
{
    public ?int $id = null;

    public ?string $cedula = null;
    public ?string $apellidos_nombres = null;
    public ?string $telefono = null;
    public ?string $correo = null;
    public ?string $serial_carnet = null;
    public ?string $codigo_carnet = null;
    public ?string $estado = null;
    public ?string $municipio = null;
    public ?string $localidad = null;
    public ?string $nombre_centro_votacion = null;

    public ?int $id_estatus = null;
    public ?string $estatus = null;
    
    public ?string $created = null;
    public ?string $updated = null;
    
}
