<?php

namespace App\Domain\Mayoristas\Repository;

use App\Factory\QueryFactory;

final class MayoristasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findMayoristass(): array
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
                    'datos_mayoristas.cantidad_locales_comerciales',
                    'datos_mayoristas.flota_vehicular'
                ]
            )

            ->leftjoin(['datos_generales_empresa'=>'datos_generales_empresa'], 'datos_generales_empresa.id = datos_mayoristas.id_datos_generales')
            ->leftjoin(['datos_representante_legal'=>'datos_representante_legal'], 'datos_representante_legal.id = id_representante_legal')
            ->leftjoin(['estados'=>'estados'], 'estados.id = datos_generales_empresa.id_estado')
            ->leftjoin(['municipios'=>'municipios'], 'municipios.id = datos_generales_empresa.id_municipio')
            ->leftjoin(['parroquias'=>'parroquias'], 'parroquias.id = datos_generales_empresa.id_parroquia')
            ->leftjoin(['tipos_mayoristas'=>'tipos_mayoristas'], 'tipos_mayoristas.id = datos_mayoristas.id_tipo_mayorista');
        
        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
