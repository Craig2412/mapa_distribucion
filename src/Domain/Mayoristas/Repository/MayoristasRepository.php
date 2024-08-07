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
                'datos_mayoristas.id',
                    //
                    'datos_mayoristas.id_datos_generales',
                        'datos_generales_empresa.razon_social',
                        'datos_generales_empresa.coordenadas_x',
                        'datos_generales_empresa.coordenadas_y',
                        'datos_generales_empresa.rif',
                        //
                            'datos_generales_empresa.id_estado',
                            'estados.estado',
                        //
                            'datos_generales_empresa.id_municipio',
                            'municipios.municipio',
                        //
                            'datos_generales_empresa.id_parroquia',
                            'parroquias.parroquia',
                        //
                            'datos_generales_empresa.id_representante_legal',
                            'datos_representante_legal.nombres',
                            'datos_representante_legal.apellidos',
                            'datos_representante_legal.identificacion',
                            'datos_representante_legal.correo AS correo_representante',
                            'datos_representante_legal.telefono AS telefono_representante',
                        //
                            'datos_generales_empresa.telefono AS telefono_empresa',
                            'datos_generales_empresa.correo AS correo_empresa',
                            'datos_generales_empresa.sector',
                            'datos_generales_empresa.sub_sector',
                        //
                            'datos_mayoristas.id_tipo_mayorista',
                            'tipos_mayoristas.tipo_mayorista',
                        //
                    'datos_mayoristas.cantidad_locales_comerciales',
                    'datos_mayoristas.capacidad_almacenamiento',
                    'datos_mayoristas.capacidad_almacenamiento_frio',
                    'datos_mayoristas.tamaño_infraestructura',
                    'datos_mayoristas.precio_volumen',
                    'datos_mayoristas.frecuencia_reposicion',
                    'datos_mayoristas.cantidad_trabajadores_directos',
                    'datos_mayoristas.volumen_mensual_comercializacion_mercancia',
                    'datos_mayoristas.flota_vehicular'
                ]
            )

            ->leftjoin(['datos_generales_empresa'=>'datos_generales_empresa'], 'datos_generales_empresa.id = datos_mayoristas.id_datos_generales')
            ->leftjoin(['datos_representante_legal'=>'datos_representante_legal'], 'datos_representante_legal.id = id_representante_legal')
            ->leftjoin(['estados'=>'estados'], 'estados.id = datos_generales_empresa.id_estado')
            ->leftjoin(['municipios'=>'municipios'], 'municipios.id = datos_generales_empresa.id_municipio')
            ->leftjoin(['parroquias'=>'parroquias'], 'parroquias.id = datos_generales_empresa.id_parroquia')
            ->leftjoin(['tipos_mayoristas'=>'tipos_mayoristas'], 'tipos_mayoristas.id = datos_mayoristas.id_tipo_mayorista');
        
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
