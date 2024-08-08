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
        $mayoristasId = (int)$args['mayoristas_id'];
        $data = (array)$request->getParsedBody();     

            // Invoke the Domain with inputs and retain the result
            $new_data_representante = $this->mayoristasUpdater->updateMayoristas($mayoristasId, $data["datos_representante"],1);
            $new_data_general = $this->mayoristasUpdater->updateMayoristas($mayoristasId, $data["datos_generales_empresa"],2);
            $new_data_mayorista = $this->mayoristasUpdater->updateMayoristas($mayoristasId, $data["datos_mayoristas"],3);
    
            // Build the HTTP response
            return $this->renderer->json($response,['Datos nuevos' => $new_data]);
        

    }
}
