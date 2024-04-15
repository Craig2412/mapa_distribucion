<?php

namespace App\Action\Home;
use App\Auth\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
$auth = Auth::SignIn([
    "user_login" => 14
]);
var_dump($auth);

final class HomeAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write('Welcome!');


       

        return $response;
    }
}
