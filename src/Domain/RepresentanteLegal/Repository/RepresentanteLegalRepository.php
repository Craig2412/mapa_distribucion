<?php

namespace App\Domain\RepresentanteLegal\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RepresentanteLegalRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertRepresentanteLegal(array $representanteLegal): int
    {
        return (int)$this->queryFactory->newInsert('datos_representante_legal', $this->toRow($representanteLegal))
        ->execute()
        ->lastInsertId();
    }
    
    public function getRepresentanteLegalById(int $representanteLegalId): array
    {
        $query = $this->queryFactory->newSelect('datos_representante_legal');
        $query->select(
            [
                'id',
                'nombres',
                'apellidos',
                'identificacion',
                'correo',
                'telefono'
            ]
            );
            
            $query->where(['id' => $representanteLegalId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('RepresentanteLegal not found: %s', $representanteLegalId));
        }
        
        return $row;
    }

    public function getRepresentanteLegalbyCedulaById(string $representanteLegalId): array
    {
        $query = $this->queryFactory->newSelect('datos_representante_legal');
        $query->select(
            [
                'id',
                'nombres',
                'apellidos',
                'identificacion',
                'correo',
                'telefono'
            ]
            );
            
            $query->where(['identificacion' => $representanteLegalId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('RepresentanteLegal not found: %s', $representanteLegalId));
        }
        
        return $row;
    }
    
    public function updateRepresentanteLegal(int $representanteLegalId, array $representanteLegal): array
    {
        $row = $this->toRowUpdate($representanteLegal);
        
        $this->queryFactory->newUpdate('datos_representante_legal', $row)
        ->where(['id' => $representanteLegalId])
        ->execute();

        return $row;

    }

    public function existsRepresentanteLegalId(int $representanteLegalId): bool
    {
        $query = $this->queryFactory->newSelect('datos_representante_legal');
        $query->select('id')->where(['id' => $representanteLegalId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteRepresentanteLegalById(int $representanteLegalId): void
    {
        $this->queryFactory->newDelete('datos_representante_legal')
        ->where(['id' => $representanteLegalId])
        ->execute();
    }

    private function toRow(array $representanteLegal): array
    {        
        $updated = isset($representanteLegal['updated']) ? $representanteLegal['updated'] : null;
        
        return [
            'nombres' => strtoupper($representanteLegal['nombres']),
            'apellidos' => strtoupper($representanteLegal['apellidos']),
            'identificacion' => strtoupper($representanteLegal['identificacion']),
            'correo' => strtoupper($representanteLegal['correo']),
            'telefono' => strtoupper($representanteLegal['telefono'])
        ];
    }

    private function toRowUpdate(array $funcionarios): array
    {
        $updated = isset($funcionarios['updated']) ? $funcionarios['updated'] : null;
        
        $array=[];
        foreach ($funcionarios as $key => $value) {
            $array["$key"]=$value;
        }
/*
        if (empty($funcionarios['id_responsable'])) {
            unset($array['id_responsable']);
        }
*/
        return $array;
    }
}
