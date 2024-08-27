<?php

namespace App\Domain\Tokens\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class TokensRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertTokens(array $tokens): int
    {
        return (int)$this->queryFactory->newInsert('tokens', $this->toRow($tokens))
        ->execute()
        ->lastInsertId();
    }
    
    public function getTokensById(int $tokensId): array
    {
        $query = $this->queryFactory->newSelect('tokens');
        $query->select(
            [
                'tokens.id',
                'tokens.token',
                'tokens.id_usuario',
                'usuarios.nombre',
                'usuarios.apellido',
                'tokens.created',
                'tokens.updated'
            ]
        )
        ->leftjoin(['usuarios'=>'usuarios'], 'usuarios.id = tokens.id_usuario');

        $query->where(['tokens.id'=> $tokensId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Tokens no encontrados: %s', $tokensId));
        }
        
        return $row;
    }
    
    public function updateTokens(int $tokensId, array $tokens): array
    {
        $row = $this->toRowUpdate($tokens);
        
        $this->queryFactory->newUpdate('tokens', $row)
        ->where(['id' => $tokensId])
        ->execute();

        return $row;

    }

    public function existsTokensId(int $tokensId): bool
    {
        $query = $this->queryFactory->newSelect('tokens');
        $query->select('id')->where(['id' => $tokensId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteTokensById(int $tokensId): void
    {
        $this->queryFactory->newDelete('tokens')
        ->where(['id' => $tokensId])
        ->execute();
    }

    private function toRow(array $tokens): array
    {        
        return [
            'token' => strtoupper($tokens['token']),
            'id_usuario' => $tokens['id_usuario'],
            'created' =>$this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $tokens): array
    {        
        return [
            'token' => strtoupper($tokens['token']),
            'id_usuario' => $tokens['id_usuario'],
            'updated' =>$this->fecha
        ];
    }


    
}
