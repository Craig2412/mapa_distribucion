<?php

namespace App\Domain\Roles\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RolesRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertRoles(array $roles): int
    {
        return (int)$this->queryFactory->newInsert('roles', $this->toRow($roles))
            ->execute()
            ->lastInsertId();
    }

    public function getRolesById(int $rolesId): array
    {
        $query = $this->queryFactory->newSelect('roles');
        $query->select(
            [
                'id',
                'role'
            ]
        );

        $query->where(['id' => $rolesId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Roles not found: %s', $rolesId));
        }
        return $row;
    }

    public function updateRoles(int $rolesId, array $roles): array
    {
        $row = $this->toRow($roles);

        $this->queryFactory->newUpdate('roles', $row)
            ->where(['id' => $rolesId])
            ->execute();
        
        return $row;
    }

    public function existsRolesId(int $rolesId): bool
    {
        $query = $this->queryFactory->newSelect('roles');
        $query->select('id')->where(['id' => $rolesId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteRolesById(int $rolesId): void
    {
        $this->queryFactory->newDelete('roles')
            ->where(['id' => $rolesId])
            ->execute();
    }

    private function toRow(array $roles): array
    {
        return [
            'role' => strtoupper($roles['role'])
        ];
    }
}
