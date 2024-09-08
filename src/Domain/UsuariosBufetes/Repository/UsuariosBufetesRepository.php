<?php

namespace App\Domain\UsuariosBufetes\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class UsuariosBufetesRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function insertUsuariosBufetes(array $usuariosbufetes): int
    {
        return (int)$this->queryFactory->newInsert('signature_has_agents', $this->toRow($usuariosbufetes))
            ->execute()
            ->lastInsertId();
    }

    public function getUsuariosBufetesById(int $usuariosbufetesId): array
    {
        $query = $this->queryFactory->newSelect('usuarios_bufetes');
        $query->select(
            [
                'usuarios_bufetes.id',
                'usuarios_bufetes.id_usuario',
                'usuarios_bufetes.id_bufete',
                'usuarios.nombre',
                'bufetes.nombre_bufete'
            ]
        )
        ->leftjoin(['bufetes'=>'bufetes'], 'bufetes.id = usuarios_bufetes.id_bufete')
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = usuarios_bufetes.id_usuario');

        $query->where(['usuarios_bufetes.id_usuario' => $usuariosbufetesId]);

        $row = $query->execute()->fetch('assoc');
        
        if (!$row) {
            throw new DomainException(sprintf('UsuariosBufetes not found: %s', $usuariosbufetesId));
        }

        return $row;
    }

    public function updateUsuariosBufetes(int $usuariosbufetesId, array $usuariosbufetes): array
    {
        $row = $this->toRow($usuariosbufetes);

        $this->queryFactory->newUpdate('usuarios_bufetes', $row)
            ->where(['id' => $usuariosbufetesId])
            ->execute();

        return $row;
    }

    public function existsUsuariosBufetesId(int $usuariosbufetesId): bool
    {
        $query = $this->queryFactory->newSelect('usuarios_bufetes');
        $query->select('id')->where(['id' => $usuariosbufetesId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteUsuariosBufetesById(int $usuariosbufetesId): void
    {
        $this->queryFactory->newDelete('usuarios_bufetes')
            ->where(['id' => $usuariosbufetesId])
            ->execute();
    }

    private function toRow(array $usuariosbufetes): array
    {
        return [
            'id_agent' => strtoupper($usuariosbufetes['id_agent']),
            'id_signature' => strtoupper($usuariosbufetes['id_signature']),
            'id_condition' => 1
        ];
    }
}
