<?php

namespace App\Domain\Tokens\Data;

/**
 * DTO.
 */
final class TokensReaderResult
{
    public ?int $id = null;

    public ?string $token = null;
    
    public ?string $id_usuario = null;
    
    public ?string $created = null;
    
    public ?string $updated = null;
    
}
