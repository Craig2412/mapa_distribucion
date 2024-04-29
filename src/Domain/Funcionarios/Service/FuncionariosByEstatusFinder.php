<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosByEstatusFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosByEstatusFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosByEstatusFinderRepository;

function obtenerEstatuss($data) {
    
    $estatuss = [
        0 => [
              'estatus' => 'SI',
              'total' => 0
             ],
        1 => [
              'estatus' => 'NO',
              'total' => 0
             ],
        2 => [
              'estatus' => 'POR DEFINIR',
              'total' => 0
             ]
    ];
    
    // Ahora $estatuss contiene todos los estatuss de Venezuela con sus totales inicializados a 0
    
    for ($i=0; $i < count($estatuss); $i++) { 
        
        for ($x=0; $x < count($data) ; $x++) { 
            if ($estatuss[$i]['estatus'] === strtoupper($data[$x]['estatus'])) {
                $estatuss[$i]['total'] = $data[$x]['total'] + 0;
            }
        }
    }
    return $estatuss;
}


final class FuncionariosByEstatusFinder
{
    private FuncionariosByEstatusFinderRepository $repository;

    public function __construct(FuncionariosByEstatusFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFuncionariosByEstatus($estatusId,$where): FuncionariosByEstatusFinderResult
    {
        
        // Input validation
        $funcionariosByEstatus = $this->repository->findFuncionariosByEstatus($estatusId,$where);
       
        $funcionariosByEstatus = obtenerEstatuss($funcionariosByEstatus);
        
        return $this->createResult($funcionariosByEstatus);
    }

    private function createResult(array $funcionariosByEstatusRows): FuncionariosByEstatusFinderResult
    {
        $result = new FuncionariosByEstatusFinderResult();
        
        foreach ($funcionariosByEstatusRows as $funcionariosByEstatusRow) {
            $funcionariosByEstatus = new FuncionariosByEstatusFinderItem();
           
            $funcionariosByEstatus->estatus = $funcionariosByEstatusRow['estatus'];
            $funcionariosByEstatus->total = $funcionariosByEstatusRow['total'];
            

            $result->funcionariosByEstatus[] = $funcionariosByEstatus;
        }
        
        return $result;
    }
}
