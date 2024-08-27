<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Data\TokensFinderItem;
use App\Domain\Tokens\Data\TokensFinderResult;
use App\Domain\Tokens\Repository\TokensFinderRepository;

final class TokensFinder
{
    private TokensFinderRepository $repository;

    public function __construct(TokensFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTokenss(): TokensFinderResult
    {
        // Input validation
        // ...

        $tokenss = $this->repository->findTokenss();

        return $this->createResult($tokenss);
    }

    private function createResult(array $tokensRows): TokensFinderResult
    {
        $result = new TokensFinderResult();

        foreach ($tokensRows as $tokensRow) {
            $tokens = new TokensFinderItem();
            $tokens->id = $tokensRow['id'];
            $tokens->token = $tokensRow['token'];
            $tokens->id_usuario = $tokensRow['id_usuario' ];
            $tokens->nombre = $tokensRow['nombre'];
            $tokens->apellido = $tokensRow['apellido'];
            $tokens->created = $tokensRow['created'];
            $tokens->updated = $tokensRow['updated'];
           
            $result->tokenss[] = $tokens;
        }

        return $result;
    }
}
