<?php

namespace App\Action\Roles;

use App\Domain\Roles\Service\RolesDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RolesDeleterAction
{
    private RolesDeleter $rolesrDeleter;

    private JsonRenderer $renderer;

    public function __construct(RolesDeleter $rolesDeleter, JsonRenderer $renderer)
    {
        $this->rolesDeleter = $rolesDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rolesId = (int)$args['roles_id'];

        // Invoke the domain (service class)
        $this->rolesDeleter->deleteRoles($rolesId);

        // Render the json response
        return $this->renderer->json($response , 'Registro eliminado');
    }
}
