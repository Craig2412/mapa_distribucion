<?php

namespace App\Domain\Mayoristas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class MayoristasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el huso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertMayoristas(array $mayoristas): int
    {
        return (int)$this->queryFactory->newInsert('datos_mayoristas', $this->toRow($mayoristas))
        ->execute()
        ->lastInsertId();
    }
    
    public function getMayoristasById(int $mayoristasId): array
    {
        $query = $this->queryFactory->newSelect('datos_mayoristas');
        $query->select(
                [
                'id',
                'id_datos_generales',
                'id_tipo_mayorista',
                'cantidad_locales_comerciales',
                'capacidad_almacenamiento',
                'capacidad_almacenamiento_frio',
                'tamaño_infraestructura',
                'precio_volumen',
                'frecuencia reposicion',
                'cantidad_trabajadores_directos',
                'volumen_mensual_comercializacion_mercancia',
                'cantidad_locales_comerciales',
                'flota_vehicular'
                ]
            )

            //->leftjoin(['datos_generales_empresa'=>'datos_generales_empresa'], 'datos_generales_empresa.id = datos_mayoristas.id_funcionario')
            //->leftjoin(['preguntas'=>'preguntas'], 'preguntas.id = encuesta.id_pregunta');

            ;
            $query->where(['id' => $mayoristasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Mayoristas not found: %s', $mayoristasId));
        }
        
        return $row;
    }
    
    public function updateMayoristas(int $mayoristasId, array $mayoristas): array
    {
        $row = $this->toRow($mayoristas);
        
        $this->queryFactory->newUpdate('datos_mayoristas', $row)
        ->where(['id' => $mayoristasId])
        ->execute();

        return $row;

    }

    public function existsMayoristasId(int $mayoristasId): bool
    {
        $query = $this->queryFactory->newSelect('datos_mayoristas');
        $query->select('id')->where(['id' => $mayoristasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteMayoristasById(int $mayoristasId): void
    {
        $this->queryFactory->newDelete('datos_mayoristas')
        ->where(['id' => $mayoristasId])
        ->execute();
    }

    private function toRow(array $mayoristas): array
    {
        
        $updated = isset($mayoristas['updated']) ? $mayoristas['updated'] : null;
        
        return [
            'mayoristas' => strtoupper($mayoristas['mayoristas'])
        ];
    }
}
