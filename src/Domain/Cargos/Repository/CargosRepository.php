<?php

namespace App\Domain\Cargos\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class CargosRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertCargos(array $cargos): int
    {
        return (int)$this->queryFactory->newInsert('cargos', $this->toRow($cargos))
            ->execute()
            ->lastInsertId();
    }

    public function getCargosById(int $cargosId): array
    {
        $query = $this->queryFactory->newSelect('charges');
        $query->select(
            [
                'id',
                'charge'
            ]
        );

        $query->where(['id' => $cargosId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Cargos not found: %s', $cargosId));
        }

        return $row;
    }

    public function updateCargos(int $cargosId, array $cargos): void
    {
        $row = $this->toRow($cargos);

        $this->queryFactory->newUpdate('charges', $row)
            ->where(['id' => $cargosId])
            ->execute();
    }

    public function existsCargosId(int $cargosId): bool
    {
        $query = $this->queryFactory->newSelect('cargos');
        $query->select('id')->where(['id' => $cargosId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCargosById(int $cargosId): void
    {
        $this->queryFactory->newDelete('cargos')
            ->where(['id' => $cargosId])
            ->execute();
    }

    private function toRow(array $cargos): array
    {
        return [
            'charge' => $cargos['charges']
        ];
    }
}
