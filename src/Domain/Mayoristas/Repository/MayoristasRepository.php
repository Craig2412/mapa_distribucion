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
    
    public function insertMayoristas(array $mayoristas, int $paso): int
    {
                switch ($paso) {
                    case '1':
                        $tabla_bd = "datos_representante_legal";
                        break;
                    case '2':
                        $tabla_bd = "datos_generales_empresa";
                        break;
                    case '3':
                        $tabla_bd = "datos_mayoristas";
                        break;
                }

                return (int)$this->queryFactory->newInsert($tabla_bd, $this->toRow($mayoristas,$paso))
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
        
            $query->where(['datos_mayoristas.id' => $mayoristasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Mayoristas not found: %s', $mayoristasId));
        }        
        return $row;
    }
    
    public function updateMayoristas(int $mayoristasId, array $mayoristas): array
    {
        $row = $this->toRow($mayoristas);

        switch ($paso) {
            case '1':
                $tabla_bd = "datos_representante_legal";
                break;
            case '2':
                $tabla_bd = "datos_generales_empresa";
                break;
            case '3':
                $tabla_bd = "datos_mayoristas";
                break;
        }
        
        $this->queryFactory->newUpdate($tabla_bd, $row)
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

    private function toRowUpdate(array $mayoristas): array
    {      
        $array=[];
        foreach ($mayoristas as $key => $value) {
            $array["$key"]=$value;
        }
/*
        if (empty($mayoristas['responsable'])) {
            unset($array['responsable']);
        }
        if (empty($mayoristas['id_responsable'])) {
            unset($array['id_responsable']);
        }
*/

        return $array;
    }

    private function toRow(array $mayoristas, int $paso): array
    {
        switch ($paso) {
        case '1':
            return [
                'nombres' => strtoupper($mayoristas['nombres']),
                'apellidos' =>  strtoupper($mayoristas['apellidos']),
                'identificacion' => $mayoristas['identificacion'],
                'correo' => strtoupper($mayoristas['correo']),
                'telefono' => $mayoristas['telefono']
            ];
            break;
        case '2':
            return [
                'razon_social' => strtoupper($mayoristas['razon_social']),
                'coordenadas_x' =>  strtoupper($mayoristas['coordenadas_x']),
                'coordenadas_y' => $mayoristas['coordenadas_y'],
                'rif' => strtoupper($mayoristas['rif']),
                'id_estado' => $mayoristas['id_estado'],
                'id_municipio' => strtoupper($mayoristas['id_municipio']),
                'id_parroquia' =>  strtoupper($mayoristas['id_parroquia']),
                'id_representante_legal' =>  strtoupper($mayoristas['id_representante_legal']),
                'telefono' => $mayoristas['telefono'],
                'correo' => strtoupper($mayoristas['correo']),
                'sector' => $mayoristas['sector'],
                'sub_sector' => strtoupper($mayoristas['sub_sector'])
                
            ];
            break;
        case '3':
            return [
                'id_datos_generales' => $mayoristas['id_datos_generales'],
                'id_tipo_mayorista' =>  $mayoristas['id_tipo_mayorista'],
                'cantidad_locales_comerciales' => $mayoristas['cantidad_locales_comerciales'],
                'capacidad_almacenamiento' => $mayoristas['capacidad_almacenamiento'],
                'capacidad_almacenamiento_frio' => $mayoristas['capacidad_almacenamiento_frio'],
                'tamaño_infraestructura' => $mayoristas['tamaño_infraestructura'],
                'precio_volumen' => $mayoristas['precio_volumen'],
                'frecuencia_reposicion' => $mayoristas['frecuencia_reposicion'],
                'cantidad_trabajadores_directos' => $mayoristas['cantidad_trabajadores_directos'],
                'volumen_mensual_comercializacion_mercancia' => $mayoristas['volumen_mensual_comercializacion_mercancia'],
                'flota_vehicular' => $mayoristas['flota_vehicular']
            ];
            break;
        }      
    }
}


