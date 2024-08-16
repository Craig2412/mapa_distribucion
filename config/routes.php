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
           
            $app->get('', \App\Action\Roles\RolesFinderAction::class);//
            $app->get('/adscripciones', \App\Action\Roles\AdscripcionesFinderAction::class);//
            $app->get('/{roles_id}', \App\Action\Roles\RolesReaderAction::class);//
            $app->post('', \App\Action\Roles\RolesCreatorAction::class);//
            $app->put('/{roles_id}', \App\Action\Roles\RolesUpdaterAction::class);//
            $app->delete('/{roles_id}', \App\Action\Roles\RolesDeleterAction::class);//
        }
    );

    // Rubros
    $app->group(
        '/rubros',//completed
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
        '/representante',//completed
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\RepresentanteLegal\RepresentanteLegalFinderAction::class);//completed
            $app->get('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalReaderAction::class);//completed
            $app->get('/byCedula/{representanteLegal_cedula}', \App\Action\RepresentanteLegal\RepresentanteLegalbyCedulaReaderAction::class);//completed
            $app->post('', \App\Action\RepresentanteLegal\RepresentanteLegalCreatorAction::class);//completed
            $app->put('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalUpdaterAction::class);//completed
            $app->delete('/{representanteLegal_id}', \App\Action\RepresentanteLegal\RepresentanteLegalDeleterAction::class);//completed
        }
    );
    // Empresas
    $app->group(
        '/empresas',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Empresas\EmpresasFinderAction::class);//
            $app->get('/{empresa_id}', \App\Action\Empresas\EmpresasReaderAction::class);//
            $app->get('/byRif/{empresa_rif}', \App\Action\Empresas\EmpresasbyCedulaReaderAction::class);//
            $app->post('', \App\Action\Empresas\EmpresasCreatorAction::class);//
            $app->put('/{empresa_id}', \App\Action\Empresas\EmpresasUpdaterAction::class);//
            $app->delete('/{empresa_id}', \App\Action\Empresas\EmpresasDeleterAction::class);//
        }
    );
    // Estados
    $app->group(
        '/estados',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Estados\EstadosFinderAction::class);//
            $app->get('/{estados_id}', \App\Action\Estados\EstadosReaderAction::class);//
            $app->post('', \App\Action\Estados\EstadosCreatorAction::class);//
            $app->put('/{estados_id}', \App\Action\Estados\EstadosUpdaterAction::class);//
            $app->delete('/{estados_id}', \App\Action\Estados\EstadosDeleterAction::class);//
        }
    );
    // Municipios
    $app->group(
        '/municipios',
        function (RouteCollectorProxy $app) {
           
            $app->get('/byEstado/{estado_id}', \App\Action\Municipios\MunicipiosFinderAction::class);//
            $app->get('/{municipios_id}', \App\Action\Municipios\MunicipiosReaderAction::class);//
            $app->post('', \App\Action\Municipios\MunicipiosCreatorAction::class);//
            $app->put('/{municipios_id}', \App\Action\Municipios\MunicipiosUpdaterAction::class);//
            $app->delete('/{municipios_id}', \App\Action\Municipios\MunicipiosDeleterAction::class);//
        }
    );
    // Parroquias
    $app->group(
        '/parroquias',
        function (RouteCollectorProxy $app) {
           
            $app->get('/byMunicipio/{municipio_id}', \App\Action\Parroquias\ParroquiasFinderAction::class);//
            $app->get('/{parroquias_id}', \App\Action\Parroquias\ParroquiasReaderAction::class);//
            $app->post('', \App\Action\Parroquias\ParroquiasCreatorAction::class);//
            $app->put('/{parroquias_id}', \App\Action\Parroquias\ParroquiasUpdaterAction::class);//
            $app->delete('/{parroquias_id}', \App\Action\Parroquias\ParroquiasDeleterAction::class);//
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
