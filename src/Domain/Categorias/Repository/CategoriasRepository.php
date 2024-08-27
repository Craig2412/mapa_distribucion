<?php

namespace App\Domain\Categorias\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class CategoriasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function insertCategorias(array $categorias): int
    {
        return (int)$this->queryFactory->newInsert('user_requests', $this->toRow($categorias))
            ->execute()
            ->lastInsertId();
    }

    public function getCategoriasById(int $categoriasId): array
    {
        $query = $this->queryFactory->newSelect('categorias');
        $query->select(
            [
                'categorias.id',
                'categorias.categoria',
                'categorias.id_condicion',
                'categorias.id_departamento',
                'departamentos.departamento',
                'categorias.created',
                'categorias.updated'
            ]
        )->leftjoin(['departamentos'=>'departamentos'],'departamentos.id = categorias.id_departamento');

        $query->where(['categorias.id_condicion' => 1,'categorias.id' => $categoriasId]);


        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Categorias not found: %s', $categoriasId));
        }

        return $row;
    }

    public function updateCategorias(int $categoriasId, array $categorias): array
    {
        $row = $this->toRowUpdate($categorias);

        $this->queryFactory->newUpdate('categorias', $row)
            ->where(['id' => $categoriasId])
            ->execute();

        return $row;
    }

    public function existsCategoriasId(int $categoriasId): bool
    {
        $query = $this->queryFactory->newSelect('categorias');
        $query->select('id')->where(['id' => $categoriasId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCategoriasById(int $categoriasId): void
    {
        $this->queryFactory->newDelete('categorias')
            ->where(['id' => $categoriasId])
            ->execute();
    }

    private function toRow(array $categorias): array
    {
        return [
            'user_requests_ip' => $categorias['user_requests_ip'],
            'created' => $this->fecha
        ];
    }
    private function toRowUpdate(array $categorias): array
    {
        return [
            'categoria' => $categorias['categoria'],
            'id_condicion' => $categorias['id_condicion'],
            'id_departamento' => $categorias['id_departamento'],
            'updated' =>$this->fecha
        ];
    }
}
