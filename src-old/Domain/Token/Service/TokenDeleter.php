<?php

namespace App\Domain\Token\Service;

use App\Domain\Token\Repository\TokenRepository;

final class TokenDeleter
{
    private TokenRepository $repository;

    public function __construct(TokenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteToken(int $tokenId): void
    {

        $this->repository->deleteTokenById($tokenId);
    }
}
