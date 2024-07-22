<?php

namespace App\Action\Roles;

use App\Domain\Roles\Service\RolesUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RolesUpdaterAction
{
    private RolesUpdater $rolesUpdater;

    private JsonRenderer $renderer;

    public function __construct(RolesUpdater $rolesUpdater, JsonRenderer $jsonRenderer)
    {
        $this->rolesUpdater = $rolesUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        
        // Extract the form data from the request body
        $rolesId = (int)$args['roles_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->rolesUpdater->updateRoles($rolesId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datos nuevos' => $new_date]);
    }
}
