<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Data\EstatusFinderItem;
use App\Domain\Estatus\Data\EstatusFinderResult;
use App\Domain\Estatus\Repository\EstatusFinderRepository;

final class EstatusFinder
{
    private EstatusFinderRepository $repository;

    public function __construct(EstatusFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEstatuss(): EstatusFinderResult
    {
        // Input validation
        // ...

        $estatuss = $this->repository->findEstatuss();

        return $this->createResult($estatuss);
    }

    private function createResult(array $estatusRows): EstatusFinderResult
    {
        $result = new EstatusFinderResult();

        foreach ($estatusRows as $estatusRow) {
            $estatus = new EstatusFinderItem();
            $estatus->id = $estatusRow['id'];
            $estatus->estatus = $estatusRow['estatus'];
            

            $result->estatuss[] = $estatus;
        }
        //var_dump($result);

        return $result;
    }
}
