<?php

namespace App\Action\Note;

use App\Domain\Note\Data\NoteFinderResult;
use App\Domain\Note\Service\NoteFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class NoteFinderAction
{
    private NoteFinder $notesFinder;

    private JsonRenderer $renderer;

    public function __construct(NoteFinder $notesFinder, JsonRenderer $jsonRenderer)
    {
        $this->notesFinder = $notesFinder;
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

       

        $taskId = (int)$args['id_task'];

        $notes = $this->notesFinder->findNote($nro_pag,$parametros,$cant_registros,$taskId);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($notes));
    }

    public function transform(NoteFinderResult $result): array
    {
        $notes = [];

        foreach ($result->note as $note) {
            $notes[] = [
                'id' => $note->id,
                'note' => $note->note,
                'id_user' => $note->id_user,
                'name' => $note->name,
                'id_task' => $note->id_task,
                'id_file' => $note->id_file,
                'title' => $note->title,
                'created' => $note->created,
                'updated' => $note->updated 
            ];
        }

        return [
            'notes' => $notes,
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