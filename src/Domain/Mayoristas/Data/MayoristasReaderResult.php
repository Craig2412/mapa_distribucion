<?php

namespace App\Domain\Mayoristas\Data;

/**
 * DTO.
 */
final class MayoristasReaderResult
{
    public ?int $id = null;

    public ?int $id_datos_generales = null;
    public ?int $id_estado = null;
    public ?int $id_municipio = null;
    public ?int $id_parroquia = null;
    public ?int $id_representante_legal = null;
    public ?int $identificacion_representante = null;
    public ?int $telefono_representante = null;
    public ?int $telefono_empresa = null;
    public ?int $id_tipo_mayorista = null;
    public ?int $cantidad_locales_comerciales = null;
    public ?int $capacidad_almacenamiento = null;
    public ?int $capacidad_almacenamiento_frio = null;
    public ?int $tamaño_infraestructura = null;
    public ?float $precio_volumen = null;
    public ?int $cantidad_trabajadores_directos = null;
    public ?int $volumen_mensual_comercializacion_mercancia = null;
    public ?int $flota_vehicular = null;
    
    public ?string $razon_social = null;
    public ?string $coordenadas_x = null;
    public ?string $coordenadas_y = null;
    public ?string $rif = null;
    public ?string $estado = null;
    public ?string $municipio = null;
    public ?string $parroquia = null;
    public ?string $nombres_representante = null;
    public ?string $apellidos_representante = null;
    public ?string $correo_empresa = null;
    public ?string $correo_representante = null;
    public ?string $sector = null;
    public ?string $sub_sector = null;
    public ?string $tipo_mayorista = null;
    public ?string $frecuencia_reposicion = null;
    
}
