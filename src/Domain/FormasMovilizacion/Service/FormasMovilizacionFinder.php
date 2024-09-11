<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Data\FormasMovilizacionFinderItem;
use App\Domain\FormasMovilizacion\Data\FormasMovilizacionFinderResult;
use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionFinderRepository;

final class FormasMovilizacionFinder
{
    private FormasMovilizacionFinderRepository $repository;

    public function __construct(FormasMovilizacionFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFormasMovilizacions(int $id_mayorista): FormasMovilizacionFinderResult
    {
        
        $formasMovilizacions = $this->repository->findFormasMovilizacions($id_mayorista);

        return $this->createResult($formasMovilizacions);
    }

    private function createResult(array $formasMovilizacionRows): FormasMovilizacionFinderResult
    {
        $result = new FormasMovilizacionFinderResult();

        foreach ($formasMovilizacionRows as $formasMovilizacionRow) {
            $formasMovilizacion = new FormasMovilizacionFinderItem();
            $formasMovilizacion->id = $formasMovilizacionRow['id'];
            $formasMovilizacion->id_mayorista = $formasMovilizacionRow['id_mayorista'];            
            $formasMovilizacion->id_tipo_movilizacion = $formasMovilizacionRow['id_tipo_movilizacion'];            
            $formasMovilizacion->tipo_movilizacion = $formasMovilizacionRow['tipo_movilizacion'];            

            $result->formasMovilizacions[] = $formasMovilizacion;
        }

        return $result;
    }
}
