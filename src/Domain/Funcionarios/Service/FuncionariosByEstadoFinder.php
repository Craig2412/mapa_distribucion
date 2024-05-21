<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosByEstadoFinderRepository;

function obtenerEstados($tipo_total,$estados,$data) {
    
    for ($i=0; $i < count($estados); $i++) { 
        
        for ($x=0; $x < count($data) ; $x++) { 
            if ($estados[$i]['estado'] === strtoupper($data[$x]['estado'])) {
                $estados[$i][$tipo_total] = $data[$x][$tipo_total] + 0;
            }
        }
    }

    return $estados;
}


final class FuncionariosByEstadoFinder
{
    private FuncionariosByEstadoFinderRepository $repository;

    public function __construct(FuncionariosByEstadoFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFuncionariosByEstado($estatusId,$where): FuncionariosByEstadoFinderResult
    {
      $estados = [
            0 => [
                  'estado' => 'AMAZONAS',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            1 => [
                  'estado' => 'DISTRITO CAPITAL',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            2 => [
                  'estado' => 'ANZOATEGUI',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            3 => [
                  'estado' => 'APURE',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            4 => [
                  'estado' => 'ARAGUA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            5 => [
                  'estado' => 'BARINAS',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            6 => [
                  'estado' => 'BOLIVAR',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            7 => [
                  'estado' => 'CARABOBO',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            8 => [
                  'estado' => 'COJEDES',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                 ],
            9 => [
                  'estado' => 'DELTA AMACURO',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            10 => [
                  'estado' => 'FALCON',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            11 => [
                  'estado' => 'GUARICO',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            12 => [
                  'estado' => 'LARA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            13 => [
                  'estado' => 'MERIDA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            14 => [
                  'estado' => 'MIRANDA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            15 => [
                  'estado' => 'MONAGAS',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            16 => [
                  'estado' => 'NUEVA ESPARTA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            17 => [
                  'estado' => 'PORTUGUESA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            18 => [
                  'estado' => 'SUCRE',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            19 => [
                  'estado' => 'TACHIRA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            20 => [
                  'estado' => 'TRUJILLO',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            21 => [
                  'estado' => 'LA GUAIRA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            22 => [
                  'estado' => 'YARACUY',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            23 => [
                  'estado' => 'ZULIA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
                  ],
            24 => [
                  'estado' => 'DEPENDENCIAS FEDERALES',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
            ],
            25 => [
                  'estado' => 'GUYANA',
                  'total' => 0,
                  'no_total' => 0,
                  'sin_total' => 0
            ]
        ];
        // Input validation
        $funcionariosByEstado = $this->repository->findFuncionariosByEstado('total',1,$where);
        $estados = obtenerEstados('total',$estados,$funcionariosByEstado);

        $funcionariosByEstado2 = $this->repository->findFuncionariosByEstado('no_total',2,$where);
        $estados = obtenerEstados('no_total',$estados,$funcionariosByEstado2);

        $funcionariosByEstado3 = $this->repository->findFuncionariosByEstado('sin_total',3,$where);
        $estados = obtenerEstados('sin_total',$estados,$funcionariosByEstado3);

        return $this->createResult($estados);
    }

    private function createResult(array $funcionariosByEstadoRows): FuncionariosByEstadoFinderResult
    {
        $result = new FuncionariosByEstadoFinderResult();
        
        foreach ($funcionariosByEstadoRows as $funcionariosByEstadoRow) {
            $funcionariosByEstado = new FuncionariosByEstadoFinderItem();
           
            $funcionariosByEstado->estado = $funcionariosByEstadoRow['estado'];
            $funcionariosByEstado->total = $funcionariosByEstadoRow['total'];
            $funcionariosByEstado->total_no = $funcionariosByEstadoRow['no_total'];
            $funcionariosByEstado->total_sin = $funcionariosByEstadoRow['sin_total'];
            

            $result->funcionariosByEstado[] = $funcionariosByEstado;
        }
        
        return $result;
    }
}
