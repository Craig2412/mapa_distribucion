<?php

namespace App\Action\Citas;

use App\Domain\Cita\Data\CitaReaderResult;
use App\Domain\Cita\Service\CitaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitaReaderAction
{
    private CitaReader $citaReader;

    private JsonRenderer $renderer;

    public function __construct(CitaReader $citaReader, JsonRenderer $jsonRenderer)
    {
        $this->citaReader = $citaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $citaId = (int)$args['id_cita'];

        // Invoke the domain and get the result
        $cita = $this->citaReader->getCita($citaId);
       // var_dump($cita);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($cita));
    }

    private function transform(CitaReaderResult $cita): array
    {
        return [
            'id' => $cita->id,
            'fecha_cita' => $cita->fecha_cita,
            'id_requerimiento' => $cita->id_requerimiento,
            'estado' => $cita->estado,
            'id_estado' => $cita->id_estado,
            'id_formato_cita' => $cita->id_formato_cita,
            'formato_cita' => $cita->formato_citas,
            'id_condicion' => $cita->id_condicion,
            'updated' => $cita->updated,
            'created' => $cita->created           
        ];
    }
}
