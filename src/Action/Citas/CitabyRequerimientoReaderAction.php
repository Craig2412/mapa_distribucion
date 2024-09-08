<?php

namespace App\Action\Citas;

use App\Domain\Cita\Data\CitaReaderResult;
use App\Domain\Cita\Service\CitabyRequerimientoReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitabyRequerimientoReaderAction
{
    private CitabyRequerimientoReader $citabyRequerimientoReader;

    private JsonRenderer $renderer;

    public function __construct(CitabyRequerimientoReader $citabyRequerimientoReader, JsonRenderer $jsonRenderer)
    {
        $this->citabyRequerimientoReader = $citabyRequerimientoReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $citabyRequerimientoId = (int)$args['id_requerimiento'];

        // Invoke the domain and get the result
        $citabyRequerimiento = $this->citabyRequerimientoReader->getCitabyRequerimiento($citabyRequerimientoId);
       
        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($citabyRequerimiento));
    }

    private function transform(CitaReaderResult $citabyRequerimiento): array
    {
        return [
            'id' => $citabyRequerimiento->id,
            'fecha_cita' => $citabyRequerimiento->fecha_cita,
            'id_requerimiento' => $citabyRequerimiento->id_requerimiento,
            'estado' => $citabyRequerimiento->estado,
            'id_estado' => $citabyRequerimiento->id_estado,
            'id_formato_cita' => $citabyRequerimiento->id_formato_cita,
            'formato_cita' => $citabyRequerimiento->formato_citas,
            'id_condicion' => $citabyRequerimiento->id_condicion,
            'created' => $citabyRequerimiento->created,           
            'updated' => $citabyRequerimiento->updated
        ];
    }
}
