<?php

namespace App\Action\Note;

use App\Domain\Note\Data\NoteFileFinderResult;
use App\Domain\Note\Service\NoteFileFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class NoteFileFinderAction
{
    private NoteFileFinder $noteFilesFinder;

    private JsonRenderer $renderer;

    public function __construct(NoteFileFinder $noteFilesFinder, JsonRenderer $jsonRenderer)
    {
        $this->noteFilesFinder = $noteFilesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $noteId = (int)$args['id_note'];

        $noteFiles = $this->noteFilesFinder->findNoteFile($noteId);
   
        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($noteFiles));
    }

    public function transform(NoteFileFinderResult $result): array
    {
        $noteFiles = [];

        foreach ($result->noteFile as $noteFile) {
            $noteFiles[] = [
                'id' => $noteFile->id,
                'nombre' => $noteFile->file_name,
                'type_file' => $noteFile->file_type,
                'type_file_name' => $noteFile->type_file_name
            ];
        }

        return [
            'noteFiles' => $noteFiles,
        ];
    }
}
