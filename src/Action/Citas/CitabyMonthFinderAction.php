<?php

namespace App\Action\Citas;

use App\Domain\Cita\Data\CitabyMonthFinderResult;
use App\Domain\Cita\Service\CitabyMonthFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitabyMonthFinderAction
{
    
    private CitabyMonthFinder $citabyMonthsFinder;

    private JsonRenderer $renderer;

    public function __construct(CitabyMonthFinder $citabyMonthsFinder, JsonRenderer $jsonRenderer)
    {

        $this->citabyMonthsFinder = $citabyMonthsFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $year = (int)$args['year'];
       
        $citabyMonths = $this->citabyMonthsFinder->findCitabyMonth($year);
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($citabyMonths));
    }

    public function transform(CitabyMonthFinderResult $result): array
    {
        
        $citabyMonths = [];

        foreach ($result->citabyMonth as $citabyMonth) {
            $citabyMonths[] = [
                strtoupper($citabyMonth->month),
                $citabyMonth->total,
            ];
        }

        return [
            'citabyMonths' => $citabyMonths,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_citabyMonths": "some_surname"}
 
*/