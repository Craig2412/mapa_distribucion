<?php
namespace App\Action;
use Cake\Database\Connection;

final class conexionSipi
{
    public function connecting()
    {
         
           
            $conexion = pg_connect("host=172.16.0.195 port=5432 dbname=bdrpi user=postgres password=");
            $query = pg_query( $conexion, "SELECT * FROM stzderec" );
            var_dump(pg_fetch_array($query));

    }
    
}
