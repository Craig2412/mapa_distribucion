<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteFileCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

function guardarArchivo($archivo, $type) {

    $car = "";
    switch ($type) {
        case 1:
            $car = "RifFile";
            break;
        case 2:
            $car = "FotoFile";
            break;
        case 3:
            $car = "CedulaFile";
            break;
        case 4:
            $car = "TypeFile";
            break;
        case 5:
            $car = "TypeFile";
            break;
        case 6:
            $car = "AgentFile";
            break;
        
        default:
            # code...
            break;
    }
    $rutaDestino = __DIR__."/./../../../public/$car/";
    $nombreArchivo = strtoupper(uniqid() . '_' . $archivo['name']);
    $rutaCompleta = $rutaDestino . $nombreArchivo;
    $tipoArchivo = $_FILES['file']['type'];

    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        return [
                "file_name" => $nombreArchivo,
                "file_url" => $rutaCompleta, 
                "file_type" => $type
               ];
    } else {
        return false;
    }
}

final class NoteFileCreatorAction
{
    private JsonRenderer $renderer;

    private NoteFileCreator $noteFileCreator;

    public function __construct(NoteFileCreator $noteFileCreator, JsonRenderer $renderer)
    {
        $this->noteFileCreator = $noteFileCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
         // Extract the form data from the request body
         $data = (array)$request->getParsedBody();
         if (isset($_FILES['file'])) {
            $archivo = $_FILES['file'];
            $resultado = guardarArchivo($archivo, $data["file_type"]);
            if ($resultado !== false) {
                $data["file_name"] = $resultado["file_name"];
                $data["file_type"] =$data["file_type"];
                $data["file_url"] = $resultado["file_url"];
                 // Invoke the Domain with inputs and retain the result
                $noteFileId = $this->noteFileCreator->createNoteFile($data);
        
                // Build the HTTP response
                return $this->renderer
                    ->json($response, ['noteFile_id' => $noteFileId])
                    ->withStatus(StatusCodeInterface::STATUS_CREATED);

            } else {
                return $this->renderer->json($response, ['message' => 'Error al subir el archivo']) ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            }
        } else{
            return $this->renderer->json($response, ['message' => 'Esta vacio el archivo']) ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);;
        }               
    }
}
