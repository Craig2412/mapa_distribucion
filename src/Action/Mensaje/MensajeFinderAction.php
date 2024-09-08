<?php

namespace App\Action\Mensaje;

use App\Domain\Mensaje\Data\MensajeFinderResult;
use App\Domain\Mensaje\Service\MensajeFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class MensajeFinderAction
{
    private MensajeFinder $mensajesFinder;

    private JsonRenderer $renderer;

    public function __construct(MensajeFinder $mensajesFinder, JsonRenderer $jsonRenderer)
    {
        $this->mensajesFinder = $mensajesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
    //Paginador
        if (isset($args['nro_pag']) && ($args['nro_pag'] > 0)) {
            $nro_pag = (int)$args['nro_pag'];
        }else {
            $nro_pag = 1;
        }

        if (isset($args['cant_registros']) && ($args['cant_registros'] > 0)) {
            $cant_registros = $args['cant_registros'];
        }else {
            $cant_registros = 10;
        }

       

        $solicitudId = (int)$args['id_solicitud'];

        $mensajes = $this->mensajesFinder->findMensaje($nro_pag,$parametros,$cant_registros,$solicitudId);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($mensajes));
    }

    public function transform(MensajeFinderResult $result): array
    {
        $mensajes = [];

        foreach ($result->mensaje as $mensaje) {
            $mensajes[] = [
                'id' => $mensaje->id,
                'mensaje' => $mensaje->mensaje,
                'id_usuario' => $mensaje->id_usuario,
                'nombre' => $mensaje->nombre,
                'apellido' => $mensaje->apellido,
                'id_solicitud' => $mensaje->id_solicitud,
                'id_condicion' => $mensaje->id_condicion,
                'created' => $mensaje->created,
                'updated' => $mensaje->updated
            ];
        }

        return [
            'mensajes' => $mensajes,
        ];
    }
}

/*

En el código que analizamos anteriormente, la variable $args debe tener un parámetro llamado 'params' que contenga un valor específico. Este valor debe ser una cadena de texto en formato JSON. Por lo tanto, para enviar el valor adecuado en la variable $args['params'], debes asegurarte de que sea una cadena de texto en formato JSON válido. 
 
Aquí tienes un ejemplo de cómo podrías enviar el valor en la variable $args['params']: 
 
$args['params'] = '{"format_appointment": "some_value", "name": "some_name", "surname": "some_surname"}'; 
 
En este ejemplo, se utiliza un objeto JSON con las claves 'format_appointment', 'name' y 'surname', y se les asignan algunos valores. Puedes ajustar los valores y las claves según tus necesidades. 
 
Recuerda que este es solo un ejemplo y debes adaptarlo a tu caso específico, asegurándote de que el valor en la variable $args['params'] sea una cadena de texto en formato JSON válido.

*/