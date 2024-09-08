<?php

namespace App\Domain\Bufete\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class BufeteRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela

        $this->queryFactory = $queryFactory;
    }

    public function insertBufete(array $bufete): int
    {
        return (int)$this->queryFactory->newInsert('bufetes', $this->toRow($bufete))
            ->execute()
            ->lastInsertId();
    }

    public function getBufeteById(int $bufeteId): array
    {
        $query = $this->queryFactory->newSelect('bufetes');
        $query->select(
            [
                'bufetes.id',
                'bufetes.nombre_bufete',
                'bufetes.rif',
                'bufetes.correo',
                'bufetes.telefono',         
                'bufetes.id_condicion' ,               
                'bufetes.created' ,               
                'bufetes.updated'     
            ]
            );

        $query->where(['bufetes.id_condicion' => 1,'bufetes.id' => $bufeteId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Bufete not found: %s', $bufeteId));
        }

        return $row;
    }

    public function updateBufete(int $bufeteId, array $bufete): array
    {
        $row = $this->toRowUpdate($bufete);
        $this->queryFactory->newUpdate('bufetes', $row)
            ->where(['id' => $bufeteId])
            ->execute();
        return $row;
    }

    public function existsBufeteId(int $bufeteId): bool
    {
        $query = $this->queryFactory->newSelect('bufetes');
        $query->select('id')->where(['id' => $bufeteId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteBufeteById(int $bufeteId): void
    {
        $this->queryFactory->newDelete('bufetes')
            ->where(['id' => $bufeteId])
            ->execute();
    }

    private function toRow(array $bufete): array
    {
        return [
            'nombre_bufete' => $bufete['nombre_bufete'],
            'rif' => $bufete['rif'],
            'correo' => $bufete['correo'],
            'telefono' => $bufete['telefono'],
            'id_condicion' => 1,
            'created' => $this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $bufete): array
    {
        return [
            'nombre_bufete' => $bufete['nombre_bufete'],
            'rif' => $bufete['rif'],
            'correo' => $bufete['correo'],
            'telefono' => $bufete['telefono'],
            'id_condicion' => $bufete['id_condicion'],
            'updated' => $this->fecha
        ];
    }
}
