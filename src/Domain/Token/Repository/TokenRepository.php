<?php

namespace App\Domain\Token\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TokenRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertToken(array $token): array
    
    {

        $id = $this->queryFactory->newInsert('tokens', $this->toRow($token))
            ->execute()
            ->lastInsertId();
            return (array)  $this->getTokenById($id);
    }

    public function getTokenById(int $tokenId): array
    {
        $query = $this->queryFactory->newSelect('tokens');
        $query->select(
            [
                'id', 
                'token'
            ]
            );
        $query->where(['tokens.id' => $tokenId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Token not found: %s', $tokenId));
        }

        return $row;
    }

    public function getTokenByUser(int $userId): array
    {
        $query = $this->queryFactory->newSelect('tokens');
        $query->select(
            [
                'id', 
                'token'
            ]
            );
        $query->where(['tokens.id_user' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Token not found: %s', $userId));
        }

        return $row;
    }

    public function updateToken(int $tokenId, array $token): void
    {
        $row = $this->toRow($token);

        $this->queryFactory->newUpdate('tokens', $row)
            ->where(['id' => $tokenId])
            ->execute();
    }

    public function existsTokenId(int $tokenId): bool
    {
        $query = $this->queryFactory->newSelect('tokens');
        $query->select('id')->where(['id_user' => $tokenId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteTokenById(int $tokenId): void
    {
        $this->queryFactory->newDelete('tokens')
            ->where(['id' => $tokenId])
            ->execute();
    }

    private function toRow(array $usuario): array
    {
        return [
            'token' => $usuario['token'],
            'id_user' => $usuario['id_user']
            
        ];
    }
}
