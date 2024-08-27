<?php

namespace App\Domain\Solicitudes\Data;


final class SolicitudesFinderItem
{
    public ?int $id = null;

    public ?int $num_solicitud = null;
    
    public ?string $num_registro = null;
    
    public ?string $descripcion = null;
    
    public ?string $respuesta = null;
        
    public ?int $id_categoria = null;

    public ?string $categoria = null;
        
    public ?int $id_requerimiento = null;
        
    public ?int $id_condicion = null;
        
    public ?int $id_estado = null;

    public ?string $estado = null;
    
    public ?string $created = null;
    
    public ?string $updated = null;

}
