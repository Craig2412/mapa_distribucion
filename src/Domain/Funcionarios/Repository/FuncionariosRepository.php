<?php

namespace App\Domain\Funcionarios\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class FuncionariosRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertFuncionarios(array $funcionarios): int
    {
        return (int)$this->queryFactory->newInsert('funcionarios', $this->toRow($funcionarios))
        ->execute()
        ->lastInsertId();
    }
    
    public function getFuncionariosById(int $funcionariosId): array
    {
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select(
            [
                'funcionarios.id',
                'funcionarios.cedula',
                'funcionarios.apellidos_nombres',
                'funcionarios.telefono',
                'funcionarios.correo',
                'funcionarios.serial_carnet',
                'funcionarios.codigo_carnet',
                'funcionarios.estado',
                'funcionarios.municipio',
                'funcionarios.localidad',
                'funcionarios.nombre_centro_votacion',
                'funcionarios.id_estatus',
                'estatus.estatus',
                'funcionarios.created',
                'funcionarios.updated'
            ]
        )->leftjoin(['estatus'=>'estatus'], 'estatus.id = funcionarios.id_estatus');
            
            $query->where(['funcionarios.cedula' => $funcionariosId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Funcionarios not found: %s', $funcionariosId));
        }
        
        return $row;
    }
    
    public function updateFuncionarios(int $funcionariosId, array $funcionarios): array
    {
        $row = $this->toRowUpdate($funcionarios);
        
        $this->queryFactory->newUpdate('funcionarios', $row)
        ->where(['id' => $funcionariosId])
        ->execute();

        return $row;

    }

    public function existsFuncionariosId(int $funcionariosId): bool
    {
        $query = $this->queryFactory->newSelect('funcionarios');
        $query->select('id')->where(['id' => $funcionariosId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteFuncionariosById(int $funcionariosId): void
    {
        $this->queryFactory->newDelete('funcionarios')
        ->where(['id' => $funcionariosId])
        ->execute();
    }

    private function toRow(array $funcionarios): array
    {
        $updated = isset($funcionarios['updated']) ? $funcionarios['updated'] : null;
        
        return [
            'cedula' => $funcionarios['cedula'],
            'apellidos_nombres' => strtoupper($funcionarios['apellidos_nombres']),
            'telefono' => $funcionarios['telefono'],
            'correo' => strtoupper($funcionarios['correo']),
            'serial_carnet' => strtoupper($funcionarios['serial_carnet']),
            'codigo_carnet' => strtoupper($funcionarios['codigo_carnet']),
            'estado' => strtoupper($funcionarios['estado']),
            'municipio' => strtoupper($funcionarios['municipio']),
            'localidad' => strtoupper($funcionarios['localidad']),
            'nombre_centro_votacion' => strtoupper($funcionarios['nombre_centro_votacion']),
            'id_estatus' => 3,
            
            'created' => $this->fecha,
            'updated' => $updated
        ];
    }

    private function toRowUpdate(array $funcionarios): array
    {
        $updated = isset($funcionarios['updated']) ? $funcionarios['updated'] : null;
        
        return [
            'cedula' => $funcionarios['cedula'],
            'apellidos_nombres' => strtoupper($funcionarios['apellidos_nombres']),
            'telefono' => $funcionarios['telefono'],
            'correo' => strtoupper($funcionarios['correo']),
            'serial_carnet' => strtoupper($funcionarios['serial_carnet']),
            'codigo_carnet' => strtoupper($funcionarios['codigo_carnet']),
            'estado' => strtoupper($funcionarios['estado']),
            'municipio' => strtoupper($funcionarios['municipio']),
            'localidad' => strtoupper($funcionarios['localidad']),
            'nombre_centro_votacion' => strtoupper($funcionarios['nombre_centro_votacion']),
            'id_estatus' => $funcionarios['id_estatus'],
            'updated' => $this->fecha
        ];
    }
}
