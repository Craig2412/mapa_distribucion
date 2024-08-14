<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Repository\RubrosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RubrosValidatorUpdate
{
    private RubrosRepository $repository;

    public function __construct(RubrosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRubrosUpdate(int $rubrossId, array $data): void
    {
        if (!$this->repository->existsRubrosId($rubrossId)) {
            throw new DomainException(sprintf('Rubros not found: %s', $rubrossId));
        }

        $this->validateRubros($data);
    }

    public function validateRubros(array $data): void
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
                'rubro' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                    ),
                'presentacion' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                    ),
                'precio_ves' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 11)
                    ]
                    ),
                'precio_ptr' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 11)
                    ]
                    ),
            ]
        );
    }
}
