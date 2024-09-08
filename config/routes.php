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

    // Imagenes
    $app->group(
        '/imagenes',//
        function (RouteCollectorProxy $app) {           
            $app->get('', \App\Action\Imagenes\ImagenesFinderAction::class);//
            $app->get('/{imagenes_id}', \App\Action\Imagenes\ImagenesReaderAction::class);//
            $app->post('', \App\Action\Imagenes\ImagenesCreatorAction::class);//
            $app->put('/{imagenes_id}', \App\Action\Imagenes\ImagenesUpdaterAction::class);//
            $app->delete('/{imagenes_id}', \App\Action\Imagenes\ImagenesDeleterAction::class);//
        }
    );

    // TiposMayoristas
    $app->group(
        '/tiposMayoristas',//
        function (RouteCollectorProxy $app) {           
            $app->get('', \App\Action\TiposMayoristas\TiposMayoristasFinderAction::class);//completed
            $app->get('/{tiposMayoristas_id}', \App\Action\TiposMayoristas\TiposMayoristasReaderAction::class);//completed
            $app->post('', \App\Action\TiposMayoristas\TiposMayoristasCreatorAction::class);//completed
            $app->put('/{tiposMayoristas_id}', \App\Action\TiposMayoristas\TiposMayoristasUpdaterAction::class);//completed
            $app->delete('/{tiposMayoristas_id}', \App\Action\TiposMayoristas\TiposMayoristasDeleterAction::class);//completed
        }
    );

    // TiposMovilizacion
    $app->group(
        '/tiposMovilizacion',//completed
        function (RouteCollectorProxy $app) {           
            $app->get('', \App\Action\TiposMovilizacion\TiposMovilizacionFinderAction::class);//completed
            $app->get('/{tiposMovilizacion_id}', \App\Action\TiposMovilizacion\TiposMovilizacionReaderAction::class);//completed
            $app->post('', \App\Action\TiposMovilizacion\TiposMovilizacionCreatorAction::class);//completed
            $app->put('/{tiposMovilizacion_id}', \App\Action\TiposMovilizacion\TiposMovilizacionUpdaterAction::class);//completed
            $app->delete('/{tiposMovilizacion_id}', \App\Action\TiposMovilizacion\TiposMovilizacionDeleterAction::class);//completed
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
            $app->get('', \App\Action\Estados\EstadosFinderAction::class);//completed
            $app->get('/{estados_id}', \App\Action\Estados\EstadosReaderAction::class);//completed
        }
    );
    // Municipios
    $app->group(
        '/municipios',
        function (RouteCollectorProxy $app) {
            $app->get('/byEstado/{estado_id}', \App\Action\Municipios\MunicipiosFinderAction::class);//completed
            $app->get('/{municipios_id}', \App\Action\Municipios\MunicipiosReaderAction::class);//completed
        }
    );
    // Parroquias
    $app->group(
        '/parroquias',
        function (RouteCollectorProxy $app) {
            $app->get('/byMunicipio/{municipio_id}', \App\Action\Parroquias\ParroquiasFinderAction::class);//completed
            $app->get('/{parroquias_id}', \App\Action\Parroquias\ParroquiasReaderAction::class);//completed
        }
    );

    // Mayoristas
     $app->group(
        '/mayoristas',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Mayoristas\MayoristasFinderAction::class);//completed
            $app->get('/unico/{mayorista_id}', \App\Action\Mayoristas\MayoristasReaderAction::class);//completed
            $app->post('', \App\Action\Mayoristas\MayoristasCreatorAction::class);//completed
            $app->put('', \App\Action\Mayoristas\MayoristasUpdaterAction::class);//
            $app->delete('/{mayorista_id}', \App\Action\Mayoristas\MayoristasDeleterAction::class);//completed
        }
    );
   


};
