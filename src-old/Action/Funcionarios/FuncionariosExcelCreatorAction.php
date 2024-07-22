<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Service\FuncionariosCreator;
use App\Domain\Funcionarios\Service\FuncionariosReader;
use App\Domain\Funcionarios\Service\FuncionariosUpdater;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Action\argValidator;//Paginador



final class FuncionariosExcelCreatorAction
{
    private JsonRenderer $renderer;

    private FuncionariosCreator $funcionariosCreator;

    private FuncionariosReader $funcionariosReader;

    private FuncionariosUpdater $funcionariosUpdater; 
         
        public function __construct(FuncionariosCreator $funcionariosCreator, FuncionariosUpdater $funcionariosUpdater, FuncionariosReader $funcionariosReader, JsonRenderer $renderer)
    {
        $this->funcionariosCreator = $funcionariosCreator;
        $this->funcionariosUpdater = $funcionariosUpdater;
        $this->funcionariosReader = $funcionariosReader;
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
                    "cedula" => trim(utf8_encode($array[0])) > 0 ? trim(utf8_encode($array[0])) : -(trim(utf8_encode($array[0]))),
                    "apellidos_nombres" => trim(utf8_encode($array[1])),
                    "telefono" =>  substr(trim(utf8_encode($array[2])), -10),
                    "correo" => trim(utf8_encode($array[3])),
                    "serial_carnet" =>  trim(utf8_encode($array[4])),
                    "codigo_carnet" =>  trim(utf8_encode($array[5])),
                    "estado" => trim(utf8_encode($array[6])),
                    "municipio" => trim(utf8_encode($array[7])),
                    "localidad" => trim(utf8_encode($array[8])),
                    "nombre_centro_votacion" => trim(utf8_encode($array[9])),
                    "departamento" => trim(utf8_encode($array[10])),             
                    "entidad_principal" => trim(utf8_encode($array[11])),
                    "entidad_adscripcion" => trim(utf8_encode($array[12])),                
                    "responsable" => trim(utf8_encode($array[13]))                
                ];
                $cedula = intval($data["cedula"]);
                $funcionario = $this->funcionariosReader->getFuncionarios($cedula, 100);
                
                if ($funcionario->id == null) {
                    $funcionarioId = $this->funcionariosCreator->createFuncionarios($data);
                }else {
                    $funcionario->responsable = $data["responsable"];
                    $funcionario->estado = $data["estado"];
                    $funcionario_array = get_object_vars($funcionario);
                    unset($funcionario_array["estatus"], $funcionario_array["id"], $funcionario_array["created"], $funcionario_array["updated"]);

                    $funcionarioId = $this->funcionariosUpdater->updateFuncionarios($funcionario->id, $funcionario_array)["cedula"];
                }



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
