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
            $app->get('', \App\Action\Estatus\EstatusFinderAction::class);//
            $app->get('/{estatus_id}', \App\Action\Estatus\EstatusReaderAction::class);//
            $app->post('', \App\Action\Estatus\EstatusCreatorAction::class);//
            $app->put('/{estatus_id}', \App\Action\Estatus\EstatusUpdaterAction::class);//
            $app->delete('/{estatus_id}', \App\Action\Estatus\EstatusDeleterAction::class);//
        }
    );

    // Preguntas
     $app->group(
        '/preguntas',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Preguntas\PreguntasFinderAction::class);//
            $app->get('/{preguntas_id}', \App\Action\Preguntas\PreguntasReaderAction::class);//
            $app->post('', \App\Action\Preguntas\PreguntasCreatorAction::class);//
            $app->put('/{preguntas_id}', \App\Action\Preguntas\PreguntasUpdaterAction::class);//
            $app->delete('/{preguntas_id}', \App\Action\Preguntas\PreguntasDeleterAction::class);//
        }
    );


    // Funcionarios
     $app->group(
        '/funcionarios',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Funcionarios\FuncionariosFinderAction::class);//
            $app->get('/{funcionarios_cedula}', \App\Action\Funcionarios\FuncionariosReaderAction::class);//
            $app->post('', \App\Action\Funcionarios\FuncionariosCreatorAction::class);//
            $app->put('/{funcionarios_id}', \App\Action\Funcionarios\FuncionariosUpdaterAction::class);//
            $app->delete('/{funcionarios_id}', \App\Action\Funcionarios\FuncionariosDeleterAction::class);//
        }
    );

    // Encuesta
    $app->group(
        '/encuesta',
        function (RouteCollectorProxy $app) {
            $app->get('/byPresFunc/{preguntas_funcionarios}/{id}/{nro_pag}/{cant_registros}', \App\Action\Encuesta\EncuestaFiltroPregFuncFinderAction::class);//en la primera variable se elige bajo que metodo quieres buscar si por preguntas o por funcionarios (1-2) y en la segunda el id de la pregunta o del funcionario de lo cual quieres todo, las otras 3 son de un paginador cualquiera
            $app->get('', \App\Action\Encuesta\EncuestaFinderAction::class);//
            $app->post('', \App\Action\Encuesta\EncuestaCreatorAction::class);//
            $app->put('/{encuesta_id}', \App\Action\Encuesta\EncuestaUpdaterAction::class);//
            $app->delete('/{encuesta_id}', \App\Action\Encuesta\EncuestaDeleterAction::class);//
        }
    );

};
