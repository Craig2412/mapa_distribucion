<?php

namespace App\Domain\UsuariosAreas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class UsuariosAreasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function insertUsuariosAreas(array $usuariosareas): int
    {
        return (int)$this->queryFactory->newInsert('areas_has_agents', $this->toRow($usuariosareas))
            ->execute()
            ->lastInsertId();
    }

    public function getUsuariosAreasById(int $usuariosareasId): array
    {
        $query = $this->queryFactory->newSelect('usuarios_area');
        $query->select(
            [
                'usuarios_area.id',
                'usuarios_area.id_usuario',
                'usuarios_area.id_area',
                'usuarios.nombre',
                'areas.area'
            ]
        )
        ->leftjoin(['areas'=>'areas'], 'areas.id = usuarios_area.id_area')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = usuarios_area.id_usuario');

        $query->where(['usuarios_area.id_usuario' => $usuariosareasId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('UsuariosAreas not found: %s', $usuariosareasId));
        }

        return $row;
    }

    public function updateUsuariosAreas(int $usuariosareasId, array $usuariosareas): array
    {
        $row = $this->toRow($usuariosareas);

        $this->queryFactory->newUpdate('usuarios_area', $row)
            ->where(['id' => $usuariosareasId])
            ->execute();

        return $row;
    }

    public function existsUsuariosAreasId(int $usuariosareasId): bool
    {
        $query = $this->queryFactory->newSelect('usuarios_area');
        $query->select('id')->where(['id' => $usuariosareasId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteUsuariosAreasById(int $usuariosareasId): void
    {
        $this->queryFactory->newDelete('usuarios_area')
            ->where(['id' => $usuariosareasId])
            ->execute();
    }

    private function toRow(array $usuariosareas): array
    {
        return [
            'id_agent' => strtoupper($usuariosareas['id_agent']),
            'id_area' => strtoupper($usuariosareas['id_area']),
            'id_condition' => 1
        ];
    }
}
