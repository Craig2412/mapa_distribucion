<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteCreatorAction
{
    private JsonRenderer $renderer;

    private NoteCreator $noteCreator;

    public function __construct(NoteCreator $noteCreator, JsonRenderer $renderer)
    {
        $this->noteCreator = $noteCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $noteId = $this->noteCreator->createNote($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['note_id' => $noteId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
