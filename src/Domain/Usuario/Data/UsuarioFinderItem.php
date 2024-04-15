<?php

namespace App\Domain\Usuario\Data;

/**
 * DTO.
 */
final class UsuarioFinderItem
{
    public ?int $id = null;

    public ?string $name = null;
    
    public ?string $email = null;
    
    public ?string $identification = null;
    
    public ?string $id_role = null;
    public ?string $role = null;
    
    public ?string $created = null;
    public ?string $updated = null;

}

