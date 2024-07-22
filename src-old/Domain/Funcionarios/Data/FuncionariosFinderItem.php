<?php

namespace App\Domain\Funcionarios\Data;

/**
 * DTO.
 */
final class FuncionariosFinderItem
{
    public ?int $id = null;

    public ?string $cedula = null;
    public ?string $apellidos_nombres = null;
    public ?string $telefono = null;
    public ?string $correo = null;
    public ?string $estado = null;
    public ?string $entidad_adscripcion = null;

    public ?string $cantidad_responsable = null;
    public ?string $porcentaje = null;

    public ?int $id_estatus = null;
    public ?string $estatus = null;

}

/*
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
    public ?string $departamento = null;
    public ?string $entidad_principal = null;
    public ?string $entidad_adscripcion = null;

    public ?string $cantidad_responsable = null;

    public ?int $id_estatus = null;
    public ?string $estatus = null;
    
    public ?string $created = null;
    public ?string $updated = null;
*/


