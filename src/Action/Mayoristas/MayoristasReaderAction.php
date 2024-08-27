<?php

namespace App\Action\Mayoristas;

use App\Domain\Mayoristas\Data\MayoristasReaderResult;
use App\Domain\Mayoristas\Service\MayoristasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MayoristasReaderAction
{
    private MayoristasReader $mayoristasReader;

    private JsonRenderer $renderer;

    public function __construct(MayoristasReader $mayoristasReader, JsonRenderer $jsonRenderer)
    {
        $this->mayoristasReader = $mayoristasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $mayoristasId = (int)$args['mayorista_id'];

        // Invoke the domain and get the result
        $mayoristas = $this->mayoristasReader->getMayoristas($mayoristasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($mayoristas));
    }

    private function transform(MayoristasReaderResult $mayoristas): array
    {
        return [
               'id' => $mayoristas->id,
                //Datos_generales
                    'razon_social' => $mayoristas->razon_social,
                    'coordenadas_x' => $mayoristas->coordenadas_x,
                    'coordenadas_y' => $mayoristas->coordenadas_y,
                    'rif' => $mayoristas->rif,
                    //Estado
                        'id_estado' => $mayoristas->id_estado,
                        'estado' => $mayoristas->estado,
                    //Estado

                    //Municipio
                        'id_municipio' => $mayoristas->id_municipio,
                        'municipio' => $mayoristas->municipio,
                    //Municipio

                    //Parroquia
                        'id_parroquia' => $mayoristas->id_parroquia,
                        'parroquia' => $mayoristas->parroquia,
                    //Parroquia

                    //Representante_legal
                        'nombres_representante' => $mayoristas->nombres_representante,
                        'apellidos_representante' => $mayoristas->apellidos_representante,
                        'identificacion_representante' => $mayoristas->identificacion_representante,
                        'telefono_representante' => $mayoristas->telefono_representante,
                        'correo_representante' => $mayoristas->correo_representante,
                    //Representante_legal
                    'telefono_empresa' => $mayoristas->telefono_empresa,
                    'correo_empresa' => $mayoristas->correo_empresa,
                    'sector' => $mayoristas->sector,
                    'sub_sector' => $mayoristas->sub_sector,

                //Datos_generales
                //Mayorista
                    'tipo_mayorista' => $mayoristas->tipo_mayorista,
                    'id_tipo_mayorista' => $mayoristas->id_tipo_mayorista,
                    'cantidad_locales_comerciales' => $mayoristas->cantidad_locales_comerciales,
                    'capacidad_almacenamiento' => $mayoristas->capacidad_almacenamiento,
                    'capacidad_almacenamiento_frio' => $mayoristas->capacidad_almacenamiento_frio,
                    'tamaño_infraestructura' => $mayoristas->tamaño_infraestructura,
                    'precio_volumen' => $mayoristas->precio_volumen,
                    'frecuencia_reposicion' => $mayoristas->frecuencia_reposicion,
                    'cantidad_trabajadores_directos' => $mayoristas->cantidad_trabajadores_directos,
                    'volumen_mensual_comercializacion_mercancia' => $mayoristas->volumen_mensual_comercializacion_mercancia,
                    'flota_vehicular' => $mayoristas->flota_vehicular
                //Mayorista
        ];
    }
}
