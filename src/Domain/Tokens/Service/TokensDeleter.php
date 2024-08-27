<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Repository\TokensRepository;

final class TokensDeleter
{
    private TokensRepository $repository;

    public function __construct(TokensRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteTokens(int $tokensId): void
    {

        $this->repository->deleteTokensById($tokensId);
    }
}
