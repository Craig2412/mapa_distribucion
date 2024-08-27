<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Data\BufeteFinderItem;
use App\Domain\Bufete\Data\BufeteFinderResult;
use App\Domain\Bufete\Repository\BufeteFinderRepository;

final class BufeteFinder
{
    private BufeteFinderRepository $repository;

    public function __construct(BufeteFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findBufete(): BufeteFinderResult
    {
        // Input validation
        // ...

        $bufetes = $this->repository->findBufete();

        return $this->createResult($bufetes);
    }

    private function createResult(array $bufeteRows): BufeteFinderResult
    {
        $result = new BufeteFinderResult();

        foreach ($bufeteRows as $bufeteRow) {
            $bufete = new BufeteFinderItem();
            $bufete->id = $bufeteRow['id'];
            $bufete->rif = $bufeteRow['rif'];
            $bufete->correo = $bufeteRow['correo'];
            $bufete->telefono = $bufeteRow['telefono'];
            $bufete->nombre_bufete = $bufeteRow['nombre_bufete'];
            
            $bufete->id_condicion = $bufeteRow['id_condicion'];
            $bufete->created = $bufeteRow['created'];
            $bufete->updated = $bufeteRow['updated'];

            $result->bufetes[] = $bufete;
        }
        return $result;
    }
}
