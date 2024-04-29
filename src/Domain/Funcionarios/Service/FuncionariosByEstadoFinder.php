<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosByEstadoFinderRepository;

function obtenerEstados($data) {
    
    $estados = [
        0 => [
              'estado' => 'AMAZONAS',
              'total' => 0
             ],
        1 => [
              'estado' => 'DISTRITO CAPITAL',
              'total' => 0
             ],
        2 => [
              'estado' => 'ANZOÁTEGUI',
              'total' => 0
             ],
        3 => [
              'estado' => 'APURE',
              'total' => 0
             ],
        4 => [
              'estado' => 'ARAGUA',
              'total' => 0
             ],
        5 => [
              'estado' => 'BARINAS',
              'total' => 0
             ],
        6 => [
              'estado' => 'BOLÍVAR',
              'total' => 0
             ],
        7 => [
              'estado' => 'CARABOBO',
              'total' => 0
             ],
        8 => [
              'estado' => 'COJEDES',
              'total' => 0
             ],
        9 => [
              'estado' => 'DELTA AMACURO',
              'total' => 0
              ],
        10 => [
              'estado' => 'FALCÓN',
              'total' => 0
              ],
        11 => [
              'estado' => 'GUÁRICO',
              'total' => 0
              ],
        12 => [
              'estado' => 'LARA',
              'total' => 0
              ],
        13 => [
              'estado' => 'MÉRIDA',
              'total' => 0
              ],
        14 => [
              'estado' => 'MIRANDA',
              'total' => 0
              ],
        15 => [
              'estado' => 'MONAGAS',
              'total' => 0
              ],
        16 => [
              'estado' => 'NUEVA ESPARTA',
              'total' => 0
              ],
        17 => [
              'estado' => 'PORTUGUESA',
              'total' => 0
              ],
        18 => [
              'estado' => 'SUCRE',
              'total' => 0
              ],
        19 => [
              'estado' => 'TÁCHIRA',
              'total' => 0
              ],
        20 => [
              'estado' => 'TRUJILLO',
              'total' => 0
              ],
        21 => [
              'estado' => 'LA GUAIRA',
              'total' => 0
              ],
        22 => [
              'estado' => 'YARACUY',
              'total' => 0
              ],
        23 => [
              'estado' => 'ZULIA',
              'total' => 0
              ],
        24 => [
              'estado' => 'DEPENDENCIAS FEDERALES',
              'total' => 0
        ],
        25 => [
              'estado' => 'GUYANA',
              'total' => 0
        ]
    ];
    
    // Ahora $estados contiene todos los estados de Venezuela con sus totales inicializados a 0
    
    for ($i=0; $i < count($estados); $i++) { 
        
        for ($x=0; $x < count($data) ; $x++) { 
            if ($estados[$i]['estado'] === strtoupper($data[$x]['estado'])) {
                $estados[$i]['total'] = $data[$x]['total'] + 0;
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
        
        // Input validation
        $funcionariosByEstado = $this->repository->findFuncionariosByEstado($estatusId,$where);
       
        $funcionariosByEstado = obtenerEstados($funcionariosByEstado);
        
        return $this->createResult($funcionariosByEstado);
    }

    private function createResult(array $funcionariosByEstadoRows): FuncionariosByEstadoFinderResult
    {
        $result = new FuncionariosByEstadoFinderResult();
        
        foreach ($funcionariosByEstadoRows as $funcionariosByEstadoRow) {
            $funcionariosByEstado = new FuncionariosByEstadoFinderItem();
           
            $funcionariosByEstado->estado = $funcionariosByEstadoRow['estado'];
            $funcionariosByEstado->total = $funcionariosByEstadoRow['total'];
            

            $result->funcionariosByEstado[] = $funcionariosByEstado;
        }
        
        return $result;
    }
}
