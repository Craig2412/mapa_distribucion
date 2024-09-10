<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Service\ImagenesCreator;
use App\Domain\Imagenes\Service\ImagenesAsignacionCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesCreatorAction
{
    private JsonRenderer $renderer;

    private ImagenesCreator $imagenesCreator;
    private ImagenesAsignacionCreator $imagenesAsignacionCreator;

    public function __construct(ImagenesCreator $imagenesCreator, ImagenesAsignacionCreator $imagenesAsignacionCreator, JsonRenderer $renderer)
    {
        $this->imagenesCreator = $imagenesCreator;
        $this->imagenesAsignacionCreator = $imagenesAsignacionCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();
        $id_mayorista = $data["id_mayorista"];
        unset($data["id_mayorista"]);

        // Invoke the Domain with inputs and retain the result
        $imagenesId = $this->imagenesCreator->createImagenes($data);
        if ($imagenesId > 0) {
            $data = [];
            $data["id_img"] = $imagenesId;
            $data["id_mayorista"] = $id_mayorista;
            
            $imagenesAsignacionId = $this->imagenesAsignacionCreator->createImagenesAsignacion($data);
            if ($imagenesAsignacionId > 0) {
                  // Build the HTTP response
                return $this->renderer
                ->json($response, ['Message' => "Insercion Exitosa"])
                ->withStatus(StatusCodeInterface::STATUS_CREATED);
            }else {
                return $this->renderer
                ->json($response, ['error' => "Error en los datos del mayorista"])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);  
            }
        }else {
            return $this->renderer
            ->json($response, ['error' => "Error en los datos de la imagen"])
            ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);  
        }      
    }
}

/*
{
    "url" : "Aceite",
    "id_mayorista" : 1 
}
*/