<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Data\TokensReaderResult;
use App\Domain\Tokens\Repository\TokensRepository;

/**
 * Service.
 */
final class TokensReader
{
    private TokensRepository $repository;

    /**
     * The constructor.
     *
     * @param TokensRepository $repository The repository
     */
    public function __construct(TokensRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a tokens.
     *
     * @param int $tokensId The tokens id
     *
     * @return TokensReaderResult The result
     */
    public function getTokens(int $tokensId): TokensReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $tokensRow = $this->repository->getTokensById($tokensId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new TokensReaderResult();
        $result->id = $tokensRow['id'];
        $result->token = $tokensRow['token'];
        $result->id_usuario = $tokensRow['id_usuario'];
        $result->nombre = $tokensRow['nombre'];
        $result->apellido = $tokensRow['apellido'];
        $result->created = $tokensRow['created'];
        $result->updated = $tokensRow['updated'];
        
        return $result;
    }
}
