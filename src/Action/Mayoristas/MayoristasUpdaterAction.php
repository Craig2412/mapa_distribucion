<?php

namespace App\Action\Mayoristas;

use App\Domain\Mayoristas\Service\MayoristasUpdater;
use App\Domain\Mayoristas\Service\MayoristasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MayoristasUpdaterAction
{
    private MayoristasUpdater $mayoristasUpdater;
    private MayoristasReader $mayoristasReader;

    private JsonRenderer $renderer;

    public function __construct(
        MayoristasUpdater $mayoristasUpdater, 
        MayoristasReader $mayoristasReader, 
        JsonRenderer $jsonRenderer)
    {
        $this->mayoristasReader = $mayoristasReader;
        $this->mayoristasUpdater = $mayoristasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody(); 
        $new_data = [];  

            // Invoke the Domain with inputs and retain the result
        if (count($data) > 0) {
            if ($data["datos_representante"]["id"] && count($data["datos_representante"]) > 1) {
                $idActualizar = $data["datos_representante"]["id"] +0;
                unset($data["datos_representante"]["id"]);

                $new_data_representante = $this->mayoristasUpdater->updateMayoristas($idActualizar, $data["datos_representante"],1);
                if ($new_data_representante) {
                    $new_data["datos_representante"] = $new_data_representante;
                }
            }
            
            if ($data["datos_generales_empresa"]["id"] && count($data["datos_generales_empresa"]) > 1) {
                $idActualizar = $data["datos_generales_empresa"]["id"]+0;
                unset($data["datos_generales_empresa"]["id"]);

                $new_data_general = $this->mayoristasUpdater->updateMayoristas($idActualizar, $data["datos_generales_empresa"],2);
                if ($new_data_general) {
                    $new_data["datos_generales_empresa"] = $new_data_general;
                }
            }

            if ($data["datos_mayoristas"]["id"] && count($data["datos_mayoristas"]) > 1) {
                $idActualizar = $data["datos_mayoristas"]["id"]+0;
                unset($data["datos_mayoristas"]["id"]);

                $new_data_general = $this->mayoristasUpdater->updateMayoristas($idActualizar, $data["datos_mayoristas"],3);
                if ($new_data_general) {
                    $new_data["datos_mayoristas"] = $new_data_general;
                }
            }

            if (count($new_data) > 0) {
                // Build the HTTP response
                return $this->renderer->json($response,['Datos nuevos' => $new_data]);
            }else {
                // Build the HTTP response
                return $this->renderer->json($response,['Datos nuevos' => "Nada para actualizar"]);
            }
        }
        

    }
}


/* TODOS OPCIONALES
{
    "datos_representante" : {
        "id" : "1", -> obligatorio
        "nombres" : "Nombre 1 y 2",
        "apellidos" : "Apellido 1 y 2",
        "identificacion" : "Cedula",
        "correo" : "correo@gmail.com",
        "telefono" : "4127008592"
    },

    "datos_generales_empresa" : {
        "id" : "1", -> obligatorio
        "razon_social" : "Nombre Empresa",
        "coordenadas_x" : "coordenadas_x",
        "coordenadas_y" : "coordenadas_y",
        "rif" : "rif",
        "id_estado" : "id_estado",
        "id_municipio" : "id_municipio",
        "id_parroquia" : "id_parroquia",
        "telefono" : "telefono",
        "correo" : "correo",
        "sector" : "sector",
        "sub_sector" : "sub_sector",
        "id_representante_legal" : "id_representante_legal"
    },

    "datos_mayoristas" : {
        "id" : 3, -> obligatorio
        "id_datos_generales" : 3,
        "id_tipo_mayorista" : 1,
        "cantidad_locales_comerciales" : 1,
        "capacidad_almacenamiento" : 1,
        "capacidad_almacenamiento_frio" : 1,
        "tamaño_infraestructura" : 1,
        "precio_volumen" : 1,
        "frecuencia_reposicion" : 1,
        "cantidad_trabajadores_directos" : 1,
        "volumen_mensual_comercializacion_mercancia" : 1,
        "flota_vehicular" : 1
    }
}
    TODOS OPCIONALES */ 