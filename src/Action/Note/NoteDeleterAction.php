<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteDeleterAction
{
    private NoteDeleter $noteDeleter;

    private JsonRenderer $renderer;

    public function __construct(NoteDeleter $noteDeleter, JsonRenderer $renderer)
    {
        $this->noteDeleter = $noteDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $noteId = (int)$args['note_id'];
        // Invoke the domain (service class)
        $this->noteDeleter->deleteNote($noteId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
