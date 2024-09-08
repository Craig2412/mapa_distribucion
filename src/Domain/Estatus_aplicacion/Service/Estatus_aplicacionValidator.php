<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class Estatus_aplicacionValidator
{
    private Estatus_aplicacionRepository $repository;

    public function __construct(Estatus_aplicacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateEstatus_aplicacionUpdate(int $estatus_aplicacionsId, array $data): void
    {
        if (!$this->repository->existsEstatus_aplicacionId($estatus_aplicacionsId)) {
            throw new DomainException(sprintf('Estatus_aplicacion not found: %s', $estatus_aplicacionsId));
        }

        $this->validateEstatus_aplicacion($data);
    }

    public function validateEstatus_aplicacion(array $data): void
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
                'estatus_aplicacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30),
                    ]
                )
            ]
        );
    }
}
