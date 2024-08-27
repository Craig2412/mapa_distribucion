<?php

namespace App\Domain\Cargos\Service;

use App\Domain\Cargos\Data\CargoFinderItem;
use App\Domain\Cargos\Data\CargoFinderResult;
use App\Domain\Cargos\Repository\CargoFinderRepository;

final class CargoFinder
{
    private CargoFinderRepository $repository;

    public function __construct(CargoFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCustomers(): CargoFinderResult
    {
        // Input validation
        // ...

        $customers = $this->repository->findCustomers();

        return $this->createResult($customers);
    }

    private function createResult(array $customerRows): CargoFinderResult
    {
        $result = new CargoFinderResult();

        foreach ($customerRows as $customerRow) {
            $customer = new CargoFinderItem();
            $customer->id = $customerRow['id'];
            $customer->cargo = $customerRow['cargo'];

            $result->cargos[] = $customer;
        }

        return $result;
    }
}
