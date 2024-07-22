<?php

namespace App\Action\Roles;

use App\Domain\Roles\Service\RolesCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RolesCreatorAction
{
    private JsonRenderer $renderer;

    private RolesCreator $rolesCreator;

    public function __construct(RolesCreator $rolesCreator, JsonRenderer $renderer)
    {
        $this->rolesCreator = $rolesCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $rolesId = $this->rolesCreator->createRoles($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['roles_id' => $rolesId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
