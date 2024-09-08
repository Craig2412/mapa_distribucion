<?php

namespace App\Domain\Cargos\Service;

use App\Domain\Cargos\Repository\CargosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class CargosValidator
{
    private CargosRepository $repository;

    public function __construct(CargosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateCargosUpdate(int $cargosId, array $data): void
    {
        if (!$this->repository->existsCargosId($cargosId)) {
            throw new DomainException(sprintf('Cargos not found: %s', $cargosId));
        }

        $this->validateCargos($data);
    }

    public function validateCargos(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'cargos' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 10),
                        $constraint->positive(),
                    ]
                
                ),
            ]
        );
    }
}
