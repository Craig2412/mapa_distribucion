<?php

namespace App\Domain\Empresas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class EmpresasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertEmpresas(array $empresas): int
    {
        return (int)$this->queryFactory->newInsert('datos_generales_empresa', $this->toRow($empresas))
        ->execute()
        ->lastInsertId();
    }
    
    public function getEmpresasById(int $empresasId): array
    {
        $query = $this->queryFactory->newSelect('datos_generales_empresa');
        $query->select(
            [
                'datos_generales_empresa.id',
                'datos_generales_empresa.razon_social',
                'datos_generales_empresa.coordenadas_x',
                'datos_generales_empresa.coordenadas_y',
                'datos_generales_empresa.rif',
                'datos_generales_empresa.id_estado',
                'e.estado',
                'datos_generales_empresa.id_municipio',
                'm.municipio',
                'datos_generales_empresa.id_parroquia',
                'p.parroquia',
                'datos_generales_empresa.id_representante_legal',
                'datos_generales_empresa.telefono',
                'datos_generales_empresa.correo',
                'datos_generales_empresa.sector',
                'datos_generales_empresa.sub_sector'
            ]
            )
            ->innerjoin(['e'=>'estados'], 'datos_generales_empresa.id_estado = e.id')
            ->innerjoin(['m'=>'municipios'], 'datos_generales_empresa.id_municipio = m.id')
            ->innerjoin(['p'=>'parroquias'], 'datos_generales_empresa.id_parroquia = p.id');
            $query->where(['datos_generales_empresa.id' => $empresasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Empresas not found: %s', $empresasId));
        }
        
        return $row;
    }

    public function getEmpresasbyCedulaById(string $empresasId): array
    {
        $query = $this->queryFactory->newSelect('datos_generales_empresa');
        $query->select(
            [
                'id',
                'razon_social',
                'coordenadas_x',
                'coordenadas_y',
                'rif',
                'id_estado',
                'id_municipio',
                'id_parroquia',
                'id_representante_legal',
                'telefono',
                'correo',
                'sector',
                'sub_sector'
            ]
            );
            
            $query->where(['rif' => $empresasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Empresas not found: %s', $empresasId));
        }
        
        return $row;
    }
    
    public function updateEmpresas(int $empresasId, array $empresas): array
    {
        $row = $this->toRowUpdate($empresas);
        
        $this->queryFactory->newUpdate('datos_generales_empresa', $row)
        ->where(['id' => $empresasId])
        ->execute();

        return $row;

    }

    public function existsEmpresasId(int $empresasId): bool
    {
        $query = $this->queryFactory->newSelect('datos_generales_empresa');
        $query->select('id')->where(['id' => $empresasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteEmpresasById(int $empresasId): void
    {
        $this->queryFactory->newDelete('datos_generales_empresa')
        ->where(['id' => $empresasId])
        ->execute();
    }

    private function toRow(array $empresas): array
    {        
        $updated = isset($empresas['updated']) ? $empresas['updated'] : null;
        
        return [
           'razon_social' => strtoupper($mayoristas['razon_social']),
            'coordenadas_x' =>  $mayoristas['coordenadas_x'],
            'coordenadas_y' => $mayoristas['coordenadas_y'],
            'rif' => strtoupper($mayoristas['rif']),
            'id_estado' => $mayoristas['id_estado'],
            'id_municipio' => $mayoristas['id_municipio'],
            'id_parroquia' =>  $mayoristas['id_parroquia'],
            'id_representante_legal' =>  $mayoristas['id_representante_legal'],
            'telefono' => $mayoristas['telefono'],
            'correo' => strtoupper($mayoristas['correo']),
            'sector' => strupper($mayoristas['sector']),
            'sub_sector' => strtoupper($mayoristas['sub_sector'])
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
