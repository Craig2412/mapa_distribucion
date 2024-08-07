<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Data\MayoristasReaderResult;
use App\Domain\Mayoristas\Repository\MayoristasRepository;

/**
 * Service.
 */
final class MayoristasReader
{
    private MayoristasRepository $repository;

    /**
     * The constructor.
     *
     * @param MayoristasRepository $repository The repository
     */
    public function __construct(MayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a mayoristas.
     *
     * @param int $mayoristasId The mayoristas id
     *
     * @return MayoristasReaderResult The result
     */
    public function getMayoristas(int $mayoristasId): MayoristasReaderResult
    {
        // Input validation
        // Fetch data from the database
        $mayoristasRow = $this->repository->getMayoristasById($mayoristasId);

        // Optional: Add or invoke your complex business logic here
        // Create domain result
        $result = new MayoristasReaderResult();

            $result->id = $mayoristasRow['id'];
            $result->id_datos_generales = $mayoristasRow['id_datos_generales'];
            $result->razon_social = $mayoristasRow['razon_social'];
            $result->coordenadas_x = $mayoristasRow['coordenadas_x'];
            $result->coordenadas_y = $mayoristasRow['coordenadas_y'];
            $result->rif = $mayoristasRow['rif'];
            $result->id_estado = $mayoristasRow['id_estado'];
            $result->estado = $mayoristasRow['estado'];
            $result->id_municipio = $mayoristasRow['id_municipio'];
            $result->municipio = $mayoristasRow['municipio'];
            $result->id_parroquia = $mayoristasRow['id_parroquia'];
            $result->parroquia = $mayoristasRow['parroquia'];
            $result->id_representante_legal = $mayoristasRow['id_representante_legal'];
            $result->nombres_representante = $mayoristasRow['nombres'];
            $result->apellidos_representante = $mayoristasRow['apellidos'];
            $result->identificacion_representante = $mayoristasRow['identificacion'];
            $result->telefono_representante = $mayoristasRow['telefono_representante'];
            $result->correo_representante = $mayoristasRow['correo_representante'];
            $result->telefono_empresa = $mayoristasRow['telefono_empresa'];
            $result->correo_empresa = $mayoristasRow['correo_empresa'];
            $result->sector = $mayoristasRow['sector'];
            $result->sub_sector = $mayoristasRow['sub_sector'];
            $result->id_tipo_mayorista = $mayoristasRow['id_tipo_mayorista'];
            $result->tipo_mayorista = $mayoristasRow['tipo_mayorista'];
            $result->cantidad_locales_comerciales = $mayoristasRow['cantidad_locales_comerciales'];
            $result->capacidad_almacenamiento = $mayoristasRow['capacidad_almacenamiento'];
            $result->capacidad_almacenamiento_frio = $mayoristasRow['capacidad_almacenamiento_frio'];
            $result->tamaño_infraestructura = $mayoristasRow['tamaño_infraestructura'];
            $result->precio_volumen = $mayoristasRow['precio_volumen'];
            $result->frecuencia_reposicion = $mayoristasRow['frecuencia_reposicion'];
            $result->cantidad_trabajadores_directos = $mayoristasRow['cantidad_trabajadores_directos'];
            $result->volumen_mensual_comercializacion_mercancia = $mayoristasRow['volumen_mensual_comercializacion_mercancia'];
            $result->flota_vehicular = $mayoristasRow['flota_vehicular'];        
        return $result;
    }
}
