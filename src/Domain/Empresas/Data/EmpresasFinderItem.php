<?php

namespace App\Domain\Empresa\Data;

/**
 * DTO.
 */
final class EmpresaFinderItem
{
    public ?int $id = null;

    public ?string $razon_social = null;    
    public ?string $coordenadas_x = null;    
    public ?string $coordenadas_y = null;    
    public ?string $rif = null;    
    public ?string $correo = null;    
    public ?string $sector = null;    
    public ?string $sub_sector = null;    
    public ?int $id_estado = null;    
    public ?int $id_municipio = null;    
    public ?int $id_parroquia = null;    
    public ?int $id_representante_legal = null;    
    public ?int $telefono = null;    

}


