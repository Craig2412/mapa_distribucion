<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Service\FuncionariosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Action\argValidator;//Paginador



final class FuncionariosExcelCreatorAction
{
    private JsonRenderer $renderer;

    private FuncionariosCreator $funcionariosCreator;

    public function __construct(FuncionariosCreator $funcionariosCreator, JsonRenderer $renderer)
    {
        $this->funcionariosCreator = $funcionariosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        // Nombre del archivo CSV
        $archivo_csv = __DIR__.'/./../../../resources/excel/prueba.csv';

        // Abre el archivo en modo lectura
        $archivo = fopen($archivo_csv, 'r');
        $id_funcionarios = [];
        
        // Verifica si se abrió correctamente el archivo
        if ($archivo !== false) {
            // Lee el archivo línea por línea hasta el final
            while (($fila = fgetcsv($archivo)) !== false) {
                // Imprime cada fila como un array
                $array = explode(";", $fila[0]);
                $data = [
                    "cedula" => utf8_encode($array[0]),
                    "apellidos_nombres" => utf8_encode($array[1]),
                    "telefono" => $array[2],
                    "correo" => utf8_encode($array[3]),
                    "serial_carnet" => $array[4],
                    "codigo_carnet" => $array[5],
                    "estado" => utf8_encode($array[6]),
                    "municipio" => utf8_encode($array[7]),
                    "localidad" => utf8_encode($array[8]),
                    "nombre_centro_votacion" => utf8_encode($array[9]),
                    "departamento" => utf8_encode($array[10]),             
                    "entidad_principal" => utf8_encode($array[11]),
                    "entidad_adscripcion" => utf8_encode($array[12])                
                ];
            $funcionarioId = $this->funcionariosCreator->createFuncionarios($data);
            array_push($id_funcionarios, $funcionarioId);            
            }
            // Cierra el archivo después de usarlo
            fclose($archivo);
        } else {
            // Si no se pudo abrir el archivo, muestra un mensaje de error
            echo "Error al abrir el archivo CSV.";
        }


        // Invoke the Domain with inputs and retain the result

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['funcionarios_id' => $id_funcionarios])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}

// Hay que meter el excel en esta ubicacion

//$archivo_csv = __DIR__.'/./../../../resources/excel/prueba.csv';
