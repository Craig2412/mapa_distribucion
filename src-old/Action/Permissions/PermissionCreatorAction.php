<?php

namespace App\Action\Permissions;

use App\Domain\Permissions\Service\PermissionsCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PermissionCreatorAction
{
    private JsonRenderer $renderer;

    private PermissionsCreator $permissionsCreator;

    public function __construct(PermissionsCreator $permissionsCreator, JsonRenderer $renderer)
    {
        $this->permissionsCreator = $permissionsCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $permissionsId = $this->permissionsCreator->createPermissions($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['permissions_id' => $permissionsId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
