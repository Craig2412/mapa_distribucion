<?php
namespace App\Action;

final class argValidator
{
    private argValidator $argValidator;

    private JsonRenderer $renderer;

   public function whereGenerate($params,$table_name){
        $where = [];
        $fecha = null;

        foreach ($params as $filas => $value) {

            switch ($filas) {
                case 'area':
                    $filas = 'areas.area';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];   
                    break;
                
                case 'status':
                    $filas = 'status.state';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];   
                    break;
                
                case 'type_tasks':
                    $filas = 'type_tasks.tipo_tarea';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];
                    break;
                
            /*
                case 'fecha_inicial':
                    $filas = "'".$table_name.'.created';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];
                    break;
            */
                
                default:
                    break;
            }
           
            
        }
        return $where;
    }        
}
