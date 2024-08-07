<?php

namespace App\Action\Mayoristas;

use App\Domain\Mayoristas\Service\MayoristasDeleter;
use App\Domain\Mayoristas\Data\MayoristasReaderResult;
use App\Domain\Mayoristas\Service\MayoristasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MayoristasDeleterAction
{
    private MayoristasDeleter $mayoristasDeleter;
    private MayoristasReader $mayoristasReader;

    private JsonRenderer $renderer;

    public function __construct(MayoristasDeleter $mayoristasDeleter, MayoristasReader $mayoristasReader, JsonRenderer $renderer)
    {
        $this->mayoristasDeleter = $mayoristasDeleter;
        $this->mayoristasReader = $mayoristasReader;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $mayoristasId = (int)$args['mayorista_id'];

        // Invoke the domain (service class)
        $this->mayoristasDeleter->deleteMayoristas($mayoristasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
