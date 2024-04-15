<?php

namespace App\Action\Customer;


use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
require __DIR__ .'/../../../vendor/autoload.php';

final class CustomerFinderAction
{
    private CustomerFinderAction $CustomerFinderAction;
    
    private JsonRenderer $renderer;
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
       // ... your code here ...

        // Create a new response object
        $newResponse = new \Slim\Psr7\Response();

        // Add some content to the response
        $newResponse->getBody()->write('Hello, world!');

        // Set the response status code and headers
        $newResponse = $newResponse->withStatus(200)
                                  ->withHeader('Content-Type', 'text/plain');

        // Return the response object
        return $newResponse;
        
    }
    public function transform(StatusFinderResult $result): array
    {
        var_dump('holi');
        $client = new \Goutte\Client();
    
        $client
            ->request('GET', 'https://www.imdb.com/search/name/?birth_monthday=12-10')
            ->filter('div.lister-list h3 a')
            ->each(function ($node) use ($client) {
                $name = $node->text();
        
                $birthday = $client
                    ->click($node->link())
                    ->filter('#name-born-info > time')->first()
                    ->attr('datetime');
        
                $year = (new DateTimeImmutable($birthday))->format('Y');
        
                return "{$name} nació en {$year}\n"  ;
            });
        
    }
}
