<?php
namespace App\Domain\Solicitudes\Repository;
use Cake\Database\Connection;

final class SolicitudesConsultaRepository
{
    public function connectingSipi($nro_solicitud)
    {
        if (is_numeric(substr($nro_solicitud, 0, 1))=== true) {
            $solicitud = substr($nro_solicitud, 0 , 4).'-'.substr($nro_solicitud, 4);
        }else{
            $solicitud = $nro_solicitud;
        }

        $conexion = pg_connect("host=172.16.0.195 port=5432 dbname=bdrpi user=postgres password=");
        $query = pg_query($conexion, "SELECT * FROM stzderec WHERE tipo_mp = 'M' AND ( registro = '$solicitud' OR solicitud = '$solicitud') ");
        $result = pg_fetch_array($query);
        if (pg_num_rows($query) == 1) {
            $estatus = $result["estatus"];

            $query = pg_query($conexion, "SELECT * FROM stzstder WHERE tipo_mp = 'M' AND estatus = '$estatus'");
            $query = pg_fetch_array($query);
            $result["nombre_categoria"] = $query["descripcion"];

            return $result;              
        }else {
            return null;
        }    
    }
}