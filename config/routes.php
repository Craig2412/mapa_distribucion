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
            $app->get('/{roles_id}', \App\Action\Roles\RolesReaderAction::class);//completed
            $app->post('', \App\Action\Roles\RolesCreatorAction::class);//completed
            $app->put('/{roles_id}', \App\Action\Roles\RolesUpdaterAction::class);//completed
            $app->delete('/{roles_id}', \App\Action\Roles\RolesDeleterAction::class);//completed
        }
    );


     // Estatus_aplicacion
     $app->group(
        '/estatus_aplicacion',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Estatus_aplicacion\Estatus_aplicacionFinderAction::class);//completed
            $app->get('/{estatus_aplicacion_id}', \App\Action\Estatus_aplicacion\Estatus_aplicacionReaderAction::class);//completed
            $app->post('', \App\Action\Estatus_aplicacion\Estatus_aplicacionCreatorAction::class);//completed
            $app->put('/{estatus_aplicacion_id}', \App\Action\Estatus_aplicacion\Estatus_aplicacionUpdaterAction::class);//completed
            $app->delete('/{estatus_aplicacion_id}', \App\Action\Estatus_aplicacion\Estatus_aplicacionDeleterAction::class);//completed
        }
    );


    // Estatus
     $app->group(
        '/estatus',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Estatus\EstatusFinderAction::class);//completed
            $app->get('/{estatus_id}', \App\Action\Estatus\EstatusReaderAction::class);//completed
            $app->post('', \App\Action\Estatus\EstatusCreatorAction::class);//completed
            $app->put('/{estatus_id}', \App\Action\Estatus\EstatusUpdaterAction::class);//completed
            $app->delete('/{estatus_id}', \App\Action\Estatus\EstatusDeleterAction::class);//completed
        }
    );

    // Preguntas
     $app->group(
        '/preguntas',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Preguntas\PreguntasFinderAction::class);//completed
            $app->get('/{preguntas_id}', \App\Action\Preguntas\PreguntasReaderAction::class);//completed
            $app->post('', \App\Action\Preguntas\PreguntasCreatorAction::class);//completed
            $app->put('/{preguntas_id}', \App\Action\Preguntas\PreguntasUpdaterAction::class);//completed
            $app->delete('/{preguntas_id}', \App\Action\Preguntas\PreguntasDeleterAction::class);//completed
        }
    );


    // Funcionarios
     $app->group(
        '/funcionarios',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Funcionarios\FuncionariosFinderAction::class);//completed
            $app->get('/{funcionarios_cedula}', \App\Action\Funcionarios\FuncionariosReaderAction::class);//completed
            $app->post('', \App\Action\Funcionarios\FuncionariosCreatorAction::class);//completed
            $app->put('/{funcionarios_id}', \App\Action\Funcionarios\FuncionariosUpdaterAction::class);//completed
            $app->delete('/{funcionarios_id}', \App\Action\Funcionarios\FuncionariosDeleterAction::class);//completed
        }
    );

    // Encuesta
    $app->group(
        '/encuesta',
        function (RouteCollectorProxy $app) {
            $app->get('/byPresFunc/{preguntas_funcionarios}/{id}/{nro_pag}/{cant_registros}', \App\Action\Encuesta\EncuestaFiltroPregFuncFinderAction::class);//en la primera variable se elige bajo que metodo quieres buscar si por preguntas o por funcionarios (1-2) y en la segunda el id de la pregunta o del funcionario de lo cual quieres todo, las otras 3 son de un paginador cualquiera
            //completed
            $app->get('', \App\Action\Encuesta\EncuestaFinderAction::class);//completed
            $app->post('', \App\Action\Encuesta\EncuestaCreatorAction::class);//completed
            $app->put('/{encuesta_id}', \App\Action\Encuesta\EncuestaUpdaterAction::class);//completed
            $app->delete('/{encuesta_id}', \App\Action\Encuesta\EncuestaDeleterAction::class);//completed
        }
    );


     // Config
     $app->group(
        '/config',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Config\ConfigFinderAction::class);//
            $app->get('/{config_id}', \App\Action\Config\ConfigReaderAction::class);//
            $app->post('', \App\Action\Config\ConfigCreatorAction::class);//
            $app->put('/{config_id}', \App\Action\Config\ConfigUpdaterAction::class);//
            $app->delete('/{config_id}', \App\Action\Config\ConfigDeleterAction::class);//
        }
    );


     // Dashboard
     $app->group(
        '/dashboard',
        function (RouteCollectorProxy $app) {
            $app->get('/funcionariosByEstados/{estatus}', \App\Action\Funcionarios\FuncionariosByEstadoFinderAction::class);// el filtro de estatus puede ser 1, 2 o 3 (Si voto, No voto, Sin definir)
            $app->get('/funcionariosByEstatus', \App\Action\Funcionarios\FuncionariosByEstatusFinderAction::class);// 
        }
    );
};
