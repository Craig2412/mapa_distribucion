<?php

namespace App\Domain\Usuario\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class UsuarioRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertUsuario(array $usuario): int
    {
        return (int)$this->queryFactory->newInsert('users', $this->toRow($usuario))
        ->execute()
        ->lastInsertId();
    }
    
    public function getUsuarioById(int $usuarioId): array
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select(
                [
                    'users.id',
                    'users.name',
                    'users.identification',
                    'users.email',
                    'users.id_role',
                    'roles.role',
                    'users.created',
                    'users.updated'
                ]
            )
            
            ->leftjoin(['roles'=>'roles'], 'roles.id = users.id_role');
            
            $query->where(['users.id' => $usuarioId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Usuario not found: %s', $usuarioId));
        }
        
        return $row;
    }
    
    public function updateUsuario(int $usuarioId, array $usuario): array
    {
        $row = $this->toRowUpdate($usuario);
        $row["updated"] = $this->fecha; 
        
        $this->queryFactory->newUpdate('users', $row)
        ->where(['id' => $usuarioId])
        ->execute();

        return $row;

    }

    public function existsUsuarioId(int $usuarioId): bool
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select('id')->where(['id' => $usuarioId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteUsuarioById(int $usuarioId): void
    {
        $this->queryFactory->newDelete('users')
        ->where(['id' => $usuarioId])
        ->execute();
    }

    private function toRow(array $usuario): array
    { 
        return [
            'name' => strtoupper($usuario['name']),
            'identification' => $usuario['identification'],
            'email' => $usuario['email'],
            'id_role' => $usuario['id_role'],
            'pass' => $usuario['pass'],
            'created' => $this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $usuario): array
    {        
        return [
            'name' => strtoupper($usuario['name']),
            'identification' => $usuario['identification'],
            'email' => $usuario['email'],
            'id_role' => $usuario['id_role'],
            'pass' => $usuario['pass'],
            'updated' => null
        ];
    }
}
