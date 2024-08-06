<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Data\MayoristasFinderItem;
use App\Domain\Mayoristas\Data\MayoristasFinderResult;
use App\Domain\Mayoristas\Repository\MayoristasFinderRepository;

final class MayoristasFinder
{
    private MayoristasFinderRepository $repository;

    public function __construct(MayoristasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findMayoristass(): MayoristasFinderResult
    {
        // Input validation
        // ...

        $mayoristass = $this->repository->findMayoristass();

        return $this->createResult($mayoristass);
    }

    private function createResult(array $mayoristasRows): MayoristasFinderResult
    {
        $result = new MayoristasFinderResult();

        foreach ($mayoristasRows as $mayoristasRow) {
            $mayoristas = new MayoristasFinderItem();
            $mayoristas->id = $mayoristasRow['id'];
            $mayoristas->id_datos_generales = $mayoristasRow['id_datos_generales'];
            $mayoristas->razon_social = $mayoristasRow['razon_social'];
            $mayoristas->coordenadas_x = $mayoristasRow['coordenadas_x'];
            $mayoristas->coordenadas_y = $mayoristasRow['coordenadas_y'];
            $mayoristas->rif = $mayoristasRow['rif'];
            $mayoristas->id_estado = $mayoristasRow['id_estado'];
            $mayoristas->estado = $mayoristasRow['estado'];
            $mayoristas->id_municipio = $mayoristasRow['id_municipio'];
            $mayoristas->municipio = $mayoristasRow['municipio'];
            $mayoristas->id_parroquia = $mayoristasRow['id_parroquia'];
            $mayoristas->parroquia = $mayoristasRow['parroquia'];
            $mayoristas->id_representante_legal = $mayoristasRow['id_representante_legal'];
            $mayoristas->nombres_representante = $mayoristasRow['nombres'];
            $mayoristas->apellidos_representante = $mayoristasRow['apellidos'];
            $mayoristas->identificacion_representante = $mayoristasRow['identificacion'];
            $mayoristas->telefono_representante = $mayoristasRow['telefono_representante'];
            $mayoristas->correo_representante = $mayoristasRow['correo_representante'];
            $mayoristas->telefono_empresa = $mayoristasRow['telefono_empresa'];
            $mayoristas->correo_empresa = $mayoristasRow['correo_empresa'];
            $mayoristas->sector = $mayoristasRow['sector'];
            $mayoristas->sub_sector = $mayoristasRow['sub_sector'];
            $mayoristas->id_tipo_mayorista = $mayoristasRow['id_tipo_mayorista'];
            $mayoristas->tipo_mayorista = $mayoristasRow['tipo_mayorista'];
            $mayoristas->cantidad_locales_comerciales = $mayoristasRow['cantidad_locales_comerciales'];
            $mayoristas->capacidad_almacenamiento = $mayoristasRow['capacidad_almacenamiento'];
            $mayoristas->capacidad_almacenamiento_frio = $mayoristasRow['capacidad_almacenamiento_frio'];
            $mayoristas->tamaño_infraestructura = $mayoristasRow['tamaño_infraestructura'];
            $mayoristas->precio_volumen = $mayoristasRow['precio_volumen'];
            $mayoristas->frecuencia_reposicion = $mayoristasRow['frecuencia_reposicion'];
            $mayoristas->cantidad_trabajadores_directos = $mayoristasRow['cantidad_trabajadores_directos'];
            $mayoristas->volumen_mensual_comercializacion_mercancia = $mayoristasRow['volumen_mensual_comercializacion_mercancia'];
            $mayoristas->flota_vehicular = $mayoristasRow['flota_vehicular'];
            $result->mayoristass[] = $mayoristas;
        }

        return $result;
    }
}
