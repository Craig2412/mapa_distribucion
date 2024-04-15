<?php

namespace App\Action\Users;

use App\Domain\Users\Data\UsersFinderResult;
use App\Domain\Users\Service\UsersFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsersFinderAction
{
    private UsersFinder $usersFinder;

    private JsonRenderer $renderer;

    public function __construct(UsersFinder $usersFinder, JsonRenderer $jsonRenderer)
    {
        $this->usersFinder = $usersFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...
        $data = (array)$request->getParsedBody();

        $users = $this->usersFinder->findUsers($data['token']);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($users));
    }

    public function transform(UsersFinderResult $result): array
    { 
        //$result = $result->users;
        
        $users = [];
        
        //var_dump($result);

        foreach ($result->users as $state) {
            $user[] = [
                'id' => $state->id,
                'name' => $state->name,
                'surname' => $state->surname,
                'email' => $state->email,
                'identificacion' => $state->identification
            ];
        }

        return [
            'users' => $user,
        ];
    }
}
