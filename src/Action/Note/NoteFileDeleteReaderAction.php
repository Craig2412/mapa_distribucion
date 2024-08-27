<?php

namespace App\Action\Note;

use App\Domain\Note\Data\NoteFileReaderResult;
use App\Domain\Note\Service\NoteFileDeleteReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteFileDeleteReaderAction
{
 private NoteFileDeleteReader $noteFileDeleteReader;

    private JsonRenderer $renderer;

    public function __construct(NoteFileDeleteReader $noteFileDeleteReader, JsonRenderer $jsonRenderer)
    {
        $this->noteFileDeleteReader = $noteFileDeleteReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $noteFileDeleteId = (int)$args['id_file'];

        // Invoke the domain and get the result
        $noteFileDelete = $this->noteFileDeleteReader->getNoteFileDelete($noteFileDeleteId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($noteFileDelete));
    }

    private function transform(NoteFileReaderResult $noteFileDelete): array
    {
        return [
            'id' => $noteFileDelete->id,
            'nombre' => $noteFileDelete->nombre,
            'type_file' => $noteFileDelete->type_file,
            'src' => $noteFileDelete->src,
            'id_note' => $noteFileDelete->id_note,
            'fileDelete' => $noteFileDelete->fileDelete            
        ];
    }
}
 