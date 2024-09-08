<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Data\AreasFinderItem;
use App\Domain\Areas\Data\AreasFinderResult;
use App\Domain\Areas\Repository\AreasFinderRepository;

final class AreasFinder
{
    private AreasFinderRepository $repository;

    public function __construct(AreasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAreas(): AreasFinderResult
    {
        // Input validation
        // ...

        $areas = $this->repository->findAreas();

        return $this->createResult($areas);
    }

    private function createResult(array $areasRows): AreasFinderResult
    {
        $result = new AreasFinderResult();

        foreach ($areasRows as $areasRow) {
            $areas = new AreasFinderItem();
            
            $areas->id = $areasRow['id'];
            $areas->area = $areasRow['area'];

            $result->areas[] = $areas;
        }

        return $result;
    }
}
