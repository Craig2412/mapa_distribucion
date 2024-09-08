<?php

namespace App\Action\Note;

use App\Domain\Note\Data\NoteReaderResult;
use App\Domain\Note\Service\NoteReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteReaderAction
{
    private NoteReader $noteReader;

    private JsonRenderer $renderer;

    public function __construct(NoteReader $noteReader, JsonRenderer $jsonRenderer)
    {
        $this->noteReader = $noteReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $noteId = (int)$args['id_note'];

        // Invoke the domain and get the result
        $note = $this->noteReader->getNote($noteId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($note));
    }

    private function transform(NoteReaderResult $note): array
    {
        return [
            'id' => $note->id,
            'note' => $note->note,
            'id_user' => $note->id_user,
            'name' => $note->name,
            'id_task' => $note->id_task,
            'title' => $note->title,
            'id_file' => $note->id_file,
            'file_name' => $note->file_name,
            'created' => $note->created,
            'updated' => $note->updated
        ];
    }
}