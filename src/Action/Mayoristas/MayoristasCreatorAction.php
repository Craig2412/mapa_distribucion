<?php

namespace App\Action\Mayoristas;

use App\Domain\Mayoristas\Service\MayoristasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MayoristasCreatorAction
{
    private JsonRenderer $renderer;

    private MayoristasCreator $mayoristasCreator;

    public function __construct(MayoristasCreator $mayoristasCreator, JsonRenderer $renderer)
    {
        $this->mayoristasCreator = $mayoristasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = (array)$request->getParsedBody();

        //Inserto el representante
        $representanteId = $this->mayoristasCreator->createMayoristas($data["datos_representante"],1);
        if ($representanteId > 0) {
            if (!($data["datos_generales_empresa"]["id_representante_legal"])) {
                $data["datos_generales_empresa"]["id_representante_legal"] = $representanteId;
                $data["datos_generales_empresa"]["coordenadas_x"] = str_replace(",", ".", $data["datos_generales_empresa"]["coordenadas_x"]);
                $data["datos_generales_empresa"]["coordenadas_y"] = str_replace(",", ".", $data["datos_generales_empresa"]["coordenadas_y"]);
            }
           
            //Inserto los datos generales de la empresa
            $datosGeneralesId = $this->mayoristasCreator->createMayoristas($data["datos_generales_empresa"],2);  
            if ($datosGeneralesId > 0) {
                if (!($data["datos_mayorista"]["id_datos_generales"])) {
                    $data["datos_mayoristas"]["id_datos_generales"] = $datosGeneralesId;
                }
                
                //Inserto los datos del mayorista
                $mayoristasId = $this->mayoristasCreator->createMayoristas($data["datos_mayoristas"],3);
                if ($mayoristasId > 0) {
                    return $this->renderer
                        ->json($response, ['mayoristas_id' => $mayoristasId])
                        ->withStatus(StatusCodeInterface::STATUS_CREATED);
                }else {
                    return $this->renderer
                    ->json($response, ['error' => "Error en los datos del mayorista"])
                    ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
                }

            }else {
                return $this->renderer
                    ->json($response, ['error' => "Error en los datos generales de la empresa"])
                    ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            }
        
        }else {
            return $this->renderer
                ->json($response, ['error' => "Error en los datos del representante"])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }  
    }
}

/*
{
    "datos_representante" : {
        "nombres" : "Nombre 1 y 2",
        "apellidos" : "Apellido 1 y 2",
        "identificacion" : "Cedula",
        "correo" : "correo@gmail.com",
        "telefono" : "4127008592"
    },

    "datos_generales_empresa" : {
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
        ("id_representante_legal" : "id_representante_legal")->opcional
    },

    "datos_mayoristas" : {
        ("id_datos_generales" : 3,)->opcional
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
*/