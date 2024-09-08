<?php

namespace App\Action\Cargos;

use App\Domain\Cargos\Data\CargoFinderResult;
use App\Domain\Cargos\Service\CargoFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CargosFinderAction
{
    private CargoFinder $customerFinder;

    private JsonRenderer $renderer;

    public function __construct(CargoFinder $customerFinder, JsonRenderer $jsonRenderer)
    {
        $this->customerFinder = $customerFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $cargos = $this->customerFinder->findCustomers();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($cargos));
    }

    public function transform(CargoFinderResult $result): array
    {
        $cargos = [];

        foreach ($result->cargos as $customer) {
            $cargos[] = [
                'id' => $customer->id,
                'cargo' => $customer->cargo,
            ];
        }

        return [
            'cargos' => $cargos,
        ];
    }
}
