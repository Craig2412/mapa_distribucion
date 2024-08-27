<?php

namespace App\Action\Note;

use App\Domain\Note\Data\NoteFileReaderResult;
use App\Domain\Note\Service\NoteFileReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteFileReaderAction
{
 private NoteFileReader $noteFileReader;

    private JsonRenderer $renderer;

    public function __construct(NoteFileReader $noteFileReader, JsonRenderer $jsonRenderer)
    {
        $this->noteFileReader = $noteFileReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $noteFileId = (int)$args['id_file'];

        // Invoke the domain and get the result
        $noteFile = $this->noteFileReader->getNoteFile($noteFileId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($noteFile));
    }

    private function transform(NoteFileReaderResult $noteFile): array
    {
        $archivo = $noteFile->src;

        if (file_exists($archivo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($archivo).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            readfile($archivo);
            exit;
        } else {
            return ['message' => 'Error al descargar el archivo'];
        }
       
        return [
            'id' => $noteFile->id,
            'nombre' => $noteFile->nombre,
            'type_file' => $noteFile->type_file,
            'src' => $noteFile->src,
            'id_note' => $noteFile->id_note
        ];
    }
}
/*
        
        */ 