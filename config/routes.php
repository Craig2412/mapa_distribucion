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

    // Rubros
    $app->group(
        '/rubros',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Rubros\RubrosFinderAction::class);//completed
            $app->get('/{rubros_id}', \App\Action\Rubros\RubrosReaderAction::class);//completed
            $app->post('', \App\Action\Rubros\RubrosCreatorAction::class);//completed
            $app->put('/{rubros_id}', \App\Action\Rubros\RubrosUpdaterAction::class);//completed
            $app->delete('/{rubros_id}', \App\Action\Rubros\RubrosDeleterAction::class);//completed
        }
    );
    // RepresentanteLegal
    $app->group(
        '/representanteLegal',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\RepresentanteLegal\RepresentanteLegalFinderAction::class);//
            $app->get('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalReaderAction::class);//
            $app->post('', \App\Action\RepresentanteLegal\RepresentanteLegalCreatorAction::class);//
            $app->put('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalUpdaterAction::class);//
            $app->delete('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalDeleterAction::class);//
        }
    );
    // Estados
    $app->group(
        '/estados',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Estados\EstadosFinderAction::class);//completed
            $app->get('/{estados_id}', \App\Action\Estados\EstadosReaderAction::class);//completed
            $app->post('', \App\Action\Estados\EstadosCreatorAction::class);//completed
            $app->put('/{estados_id}', \App\Action\Estados\EstadosUpdaterAction::class);//completed
            $app->delete('/{estados_id}', \App\Action\Estados\EstadosDeleterAction::class);//completed
        }
    );
    // Municipios
    $app->group(
        '/municipios',
        function (RouteCollectorProxy $app) {
           
            $app->get('/byEstado/{estado_id}', \App\Action\Municipios\MunicipiosFinderAction::class);//completed
            $app->get('/{municipios_id}', \App\Action\Municipios\MunicipiosReaderAction::class);//completed
            $app->post('', \App\Action\Municipios\MunicipiosCreatorAction::class);//completed
            $app->put('/{municipios_id}', \App\Action\Municipios\MunicipiosUpdaterAction::class);//completed
            $app->delete('/{municipios_id}', \App\Action\Municipios\MunicipiosDeleterAction::class);//completed
        }
    );
    // Parroquias
    $app->group(
        '/parroquias',
        function (RouteCollectorProxy $app) {
           
            $app->get('/byMunicipio/{municipio_id}', \App\Action\Parroquias\ParroquiasFinderAction::class);//completed
            $app->get('/{parroquias_id}', \App\Action\Parroquias\ParroquiasReaderAction::class);//completed
            $app->post('', \App\Action\Parroquias\ParroquiasCreatorAction::class);//completed
            $app->put('/{parroquias_id}', \App\Action\Parroquias\ParroquiasUpdaterAction::class);//completed
            $app->delete('/{parroquias_id}', \App\Action\Parroquias\ParroquiasDeleterAction::class);//completed
        }
    );

    // Mayoristas
     $app->group(
        '/mayoristas',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Mayoristas\MayoristasFinderAction::class);//COMPLETED
            $app->get('/unico/{mayorista_id}', \App\Action\Mayoristas\MayoristasReaderAction::class);//COMPLETED
            $app->post('/excel', \App\Action\Mayoristas\MayoristasExcelCreatorAction::class);//
            $app->post('', \App\Action\Mayoristas\MayoristasCreatorAction::class);//
            $app->put('/{mayorista_id}', \App\Action\Mayoristas\MayoristasUpdaterAction::class);//
            $app->delete('/{mayorista_id}', \App\Action\Mayoristas\MayoristasDeleterAction::class);//COMPLETED
        }
    );
   


};
