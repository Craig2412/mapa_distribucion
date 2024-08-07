<?php

// Define app routes
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');
    $app->get('/dashboard', \App\Action\Home\TaskbyStatusFinderAction::class)->setName('dashboard');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

     //Auth
     $app->group(
        '/auth',
        function (RouteCollectorProxy $app) { 
            $app->post('/user/create', \App\Action\Auth\AuthSigninAction::class);
            $app->post('/user/authentication', \App\Action\Auth\AuthLoginAction::class);
            $app->get('/token/authentication', \App\Action\Auth\AuthVerificateAction::class);
        }
    );
 
    //User
    $app->group(
        '/user',
        function (RouteCollectorProxy $app) { 
            $app->post('/token', \App\Action\Users\UsersFinderAction::class);
        }
    );

    // Roles
    $app->group(
        '/roles',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Roles\RolesFinderAction::class);//completed
            $app->get('/adscripciones', \App\Action\Roles\AdscripcionesFinderAction::class);//
            $app->get('/{roles_id}', \App\Action\Roles\RolesReaderAction::class);//completed
            $app->post('', \App\Action\Roles\RolesCreatorAction::class);//completed
            $app->put('/{roles_id}', \App\Action\Roles\RolesUpdaterAction::class);//completed
            $app->delete('/{roles_id}', \App\Action\Roles\RolesDeleterAction::class);//completed
        }
    );

    // Mayoristas
     $app->group(
        '/mayoristas',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Mayoristas\MayoristasFinderAction::class);//COMPLETED
            $app->get('/unico/{mayorista_id}', \App\Action\Mayoristas\MayoristasReaderAction::class);//COMPLETED
            $app->post('/excel', \App\Action\Mayoristas\MayoristasExcelCreatorAction::class);//
            $app->post('', \App\Action\Roles\RolesCreatorAction::class);//
            $app->put('/{mayorista_id}', \App\Action\Mayoristas\MayoristasUpdaterAction::class);//
            $app->delete('/{mayorista_id}', \App\Action\Mayoristas\MayoristasDeleterAction::class);//COMPLETED
        }
    );
   


};
