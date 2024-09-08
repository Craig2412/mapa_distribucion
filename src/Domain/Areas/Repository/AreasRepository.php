<?php

namespace App\Domain\Areas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class AreasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function insertAreas(array $areas): int
    {
        return (int)$this->queryFactory->newInsert('areas', $this->toRow($areas))
            ->execute()
            ->lastInsertId();
    }

    public function getAreasById(int $areasId): array
    {
        $query = $this->queryFactory->newSelect('areas');
        $query->select(
            [
                'areas.id',
                'areas.area' 
            ]
        );

        $query->where(['id' => $areasId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Areas not found: %s', $areasId));
        }

        return $row;
    }

    public function updateAreas(int $areasId, array $areas): array
    {
        $row = $this->toRow($areas);

        $this->queryFactory->newUpdate('areas', $row)
            ->where(['id' => $areasId])
            ->execute();

        return $row;
    }

    public function existsAreasId(int $areasId): bool
    {
        $query = $this->queryFactory->newSelect('areas');
        $query->select('id')->where(['id' => $areasId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteAreasById(int $areasId): void
    {
        $this->queryFactory->newDelete('areas')
            ->where(['id' => $areasId])
            ->execute();
    }

    private function toRow(array $areas): array
    {
        return [
            'area' => strtoupper($areas['area'])
        ];
    }
}
