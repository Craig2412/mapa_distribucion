<?php

namespace App\Action\Note;

use App\Domain\Note\Service\NoteUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class NoteUpdaterAction
{
    private NoteUpdater $noteUpdater;

    private JsonRenderer $renderer;

    public function __construct(NoteUpdater $noteUpdater, JsonRenderer $jsonRenderer)
    {
        $this->noteUpdater = $noteUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $noteId = (int)$args['note_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->noteUpdater->updateNote($noteId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['update' => $new_date]);
    }
}
