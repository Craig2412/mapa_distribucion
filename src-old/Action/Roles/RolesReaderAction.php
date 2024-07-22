<?php

namespace App\Action\Roles;

use App\Domain\Roles\Data\RolesReaderResult;
use App\Domain\Roles\Service\RolesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RolesReaderAction
{
    private RolesReader $rolesReader;

    private JsonRenderer $renderer;

    public function __construct(RolesReader $rolesReader, JsonRenderer $jsonRenderer)
    {
        $this->rolesReader = $rolesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rolesId = (int)$args['roles_id'];

        // Invoke the domain and get the result
        $roles = $this->rolesReader->getRoles($rolesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($roles));
    }

    private function transform(RolesReaderResult $roles): array
    {
        
        return [
            'id' => $roles->id,
            'role' => $roles->role
        ];
    }
}
